<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Tag;
use App\Services\MarkdownParser;
use Illuminate\Support\Facades\DB;

class PostRepository
{
	use BaseRepositoryTrait, PaginateRepositoryTrait;

	protected $markdownParser;
	protected $tagRepository;

	protected $model;

	public function __construct(Post $model, MarkdownParser $markdownParser, TagRepository $tagRepository)
	{
		$this->model = $model;
		$this->markdownParser = $markdownParser;
		$this->tagRepository = $tagRepository;
	}

	public function get($slug)
    {
		$post = Post::where('slug', $slug)->with(['tags', 'category'])->withCount('comments as comments_count')->firstOrFail();
		DB::table('posts')->where('id', $post->id)->increment('view_count');

		return $post;
	}

	public function getById($id)
	{
		return Post::withoutGlobalScopes()->with(['tags', 'category'])->withCount('comments as comments_count')->findOrFail($id);
	}

	/**
	 * @param int $count
	 * @return mixed
	 */
	public function hot($count = 5)
	{
		$posts = $this->remember('post.hot.' . $count, function () use ($count) {
			return Post::select([
				'title',
				'slug',
				'view_count',
			])->withCount('comments as comments_count')->orderBy('view_count', 'desc')->limit($count)->get();
		});
		return $posts;
	}

	/**
	 * @param int $limit
	 * @return mixed
	 */
	public function archive($limit = 12)
	{
		$posts = $this->remember('post.achieve', function () use ($limit) {
			return self::select(['id','title','slug','content','created_at','category_id'])
                			->where(DB::raw("DATE_FORMAT(`created_at`, '%Y %c')"), '=', "$year $month")
                			->where('category_id', '<>', 0)
                			->latest()
                			->paginate($limit);
		});
		return $posts;
	}

	/**
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data)
	{
		$this->clearAllCache();

		/** @var Post $post */
		$post = auth()->user()->posts()->create(
			array_merge(
				$data,
				[
					'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false),
				]
			)
		);

		$post->save(); # save it in scout

		$this->syncTags($post, $data['tag_list']);

		$post->saveConfig($data);

		return $post;
	}

	/**
	 * @param array
	 * @param int $id
	 * @return mixed
	 */
	public function update(array $data, $id)
	{
		$this->clearAllCache();

		/** @var Post $post */
		$post = $this->getById($id);

		$this->syncTags($post, $data['tag_list']);

		$post->saveConfig($data);

		$result = $post->update(
			array_merge($data, [
			    'html_content' => $this->markdownParser->convertMarkdownToHtml($data['content'], false)
            ])
		);

		$result && $post->save(); # update it in scout

		return $result;
	}

	public function delete($id)
	{
		$this->clearAllCache();
		/** @var Post $post */
		$post = $this->getById($id);
		$result = $post->destroy($id);

		$result && $post->delete(); # delete from scout

		return $result;
	}

    /**
     *
     * @param  string $keyword
     * @return collection
     */
    public function search($keyword)
    {
	    if (env('SCOUT_DRIVER')) {
			return $this->model()->search($keyword)->paginate();
	    } else {
		    $keyword = trim($keyword);
		    return $this->model()
			    ->where('title', 'like', "%{$keyword}%")
			    ->orWhere('content', 'like', "%{$keyword}%")
			    ->orderBy('published_at', 'desc')
			    ->get();
	    }
    }

	/**
	 * sync tags of the given post
	 * @param  Post $post [description]
	 * @param  array   $tags    [description]
	 */
	private function syncTags(Post $post, array $tags)
	{
		#extract the input into separate numeric and string arrays
		$currentTags = array_filter($tags, 'is_numeric'); # ["1", "3", "5"]
		$newTags = array_diff($tags, $currentTags); # ["awesome", "cool"]

		#Create a new tag for each string in the input and update the current tags array
		foreach ($newTags as $newTag)
		{
			if ($tag = Tag::firstOrCreate(['name' => $newTag]))
			{
				$currentTags[] = $tag->id;
			}
		}

		#recalculate the cited number of the tags related to the given post
		$oldTags = $post->tags()->get()->keyBy('id')->keys()->toArray();
		$decTags = array_diff($oldTags, $currentTags);
		$incTags = array_diff($currentTags, $oldTags);
		DB::table('tags')->whereIn('id', $incTags)->increment('cited_count');
		DB::table('tags')->whereIn('id', $decTags)->decrement('cited_count');

		#sync the pivot table of post_tag
		$post->tags()->sync($currentTags);
	}
}

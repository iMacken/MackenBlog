<?php
namespace App\Repositories;

use App\Models\Tag;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class TagRepository
{
    use BaseRepositoryTrait, PaginateRepositoryTrait;

    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

	public function update(array $data, $id)
	{
		$tag = $this->find($id);
		$tag = $tag->update($data);

		return $tag;
	}

	public function delete($id)
	{
	    /** @var Tag $tag */
        $tag = $this->find($id);

		if ($tag->posts()->count() > 0) {
			throw new AccessDeniedHttpException('该标签下有文章,不能删除');
		}

		return $tag->destroy($id);
	}

	/**
	 * @param int $count
	 * @return mixed
	 */
	public function hot($count = 12)
	{
			return Tag::query()->select([
				'name',
				'slug',
				'cited_count',
			])->orderBy('click_count', 'desc')->limit($count)->get();
	}
}

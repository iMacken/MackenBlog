import Dashboard from './views/Dashboard.vue'
import Parent from './views/Parent.vue'

export default [
    {
        path: '/dashboard',
        component: Dashboard,
        beforeEnter: requireAuth,
        children: [
            {
                path: '/',
                redirect: '/home'
            },
            {
                path: 'home',
                component: require('./views/Home.vue')
            },
            {
                path: 'users',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/user/User.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/user/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/user/Edit.vue')
                    }
                ]
            },
            {
                path: 'articles',
                component: Parent,
                children: [
                    {
                        path: '/',
                        name: 'articles',
                        component: require('./views/article/Article.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/article/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/article/Edit.vue')
                    }
                ]
            },
            {
                path: 'discussions',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/discussion/Discussion.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/discussion/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/discussion/Edit.vue')
                    }
                ]
            },
            {
                path: 'comments',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/comment/Comment.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/comment/Edit.vue')
                    }
                ]
            },
            {
                path: 'tags',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/tag/Tag.vue')
                    },
                    {
                        path: 'Create',
                        component: require('./views/tag/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/tag/Edit.vue')
                    }
                ]
            },
            {
                path: 'files',
                component: require('./views/File.vue')
            },
            {
                path: 'categories',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/category/Category.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/category/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/category/Edit.vue')
                    }
                ]
            },
            {
                path: 'links',
                component: Parent,
                children: [
                    {
                        path: '/',
                        component: require('./views/link/Link.vue')
                    },
                    {
                        path: 'create',
                        component: require('./views/link/Create.vue')
                    },
                    {
                        path: ':id/edit',
                        component: require('./views/link/Edit.vue')
                    }
                ]
            },
            {
                path: 'visitors',
                component: require('./views/Visitor.vue')
            },
            {
                path: 'system',
                component: require('./views/System.vue')
            },
            {
                path: '*',
                redirect: '/dashboard'
            }
        ]
    }
]

function requireAuth (to, from, next) {
    if (window.User) {
        return next()
    } else {
        return next('/')
    }
}
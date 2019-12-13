import Vue from 'vue';
import VueRouter from "vue-router";

import Login from '@/js/views/Login';
import Register from '@/js/views/Register';
import Home from '@/js/views/Home';
import Images from '@/js/views/Images';
import Image from '@/js/views/Image';
import ImageEdit from "@/js/views/ImageEdit";
import Articles from "@/js/views/Articles";
import Article from "@/js/views/Article";
import ArticleEdit from "@/js/views/ArticleEdit";
import Publish from "@/js/views/Publish";

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Login'
                    }
                ]
            }
        },

        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                auth: false,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Register'
                    }
                ]
            }
        },

        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },                ]
            }
        },

        {
            path: '/images/:page?',
            name: 'images',
            component: Images,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Images'
                    }
                ]
            }
        },

        {
            path: '/image/:id',
            name: 'image',
            component: Image,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Images',
                        to: '/images'
                    },
                    {
                        text: 'View image'
                    }
                ]
            }
        },

        {
            path: '/image/:id/edit',
            name: 'image.edit',
            component: ImageEdit,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Images',
                        to: '/images'
                    },
                    {
                        text: 'Edit image'
                    }
                ]
            }
        },

        {
            path: '/articles/:page?',
            name: 'articles',
            component: Articles,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Articles'
                    }
                ]
            }
        },

        {
            path: '/article/:id',
            name: 'article',
            component: Article,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Articles',
                        to: '/articles'
                    },
                    {
                        text: 'View article'
                    }
                ]
            }
        },
        {
            path: '/article/:id/edit',
            name: 'article.edit',
            component: ArticleEdit,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'Articles',
                        to: '/articles'
                    },
                    {
                        text: 'Edit article'
                    }
                ]
            }
        },

        {
            path: '/publish',
            name: 'publish',
            component: Publish,
            meta: {
                auth: true,
                breadcrumb: [
                    {
                        text: 'Home',
                        to: '/'
                    },
                    {
                        text: 'New publication',
                    }
                ]
            }
        }
    ]
});

export default router;

import VueRouter from 'vue-router';

let routes = [
	{
		path: '/',
		component: require('./views/Home')
	}, {
		path: '/gallery',
		component: require('./views/Gallery')
	}
]


export default new VueRouter({
	routes,
	linkActiveClass: 'active'
});
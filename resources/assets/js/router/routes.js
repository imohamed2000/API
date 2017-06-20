module.exports = [
	{path: '/', component: require('../components/Stats'), name: 'stats', meta: {title: "Home"}},
	{path: '/schools', component: require('../components/Schools'), name: 'schools', meta: {title: "All Schools"} },
	{path: '*', component: require('../components/NotFound'), name: '404', meta: {title: 'Error 404'}}
];

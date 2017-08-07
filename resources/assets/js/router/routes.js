module.exports = [
	{path: '/', component: require('../components/Stats'), name: 'stats',
		 meta: {
		 	title: "Home",
		 	pageTitle: "Dashboard"
	 }},

	{path: '/schools', component: require('../components/SchoolsIndex'), name: 'schools',
		meta: {
				title: "All Schools",
				pageTitle: "All Schools"
	}},

	{path: '*', component: require('../components/NotFound'), name: '404', meta: {title: 'Error 404'}}
];

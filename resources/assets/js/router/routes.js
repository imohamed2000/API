module.exports = [
	// Entry page
	{path: '/', component: require('../components/Stats'), name: 'stats',
		 meta: {
		 	title: "Home",
		 	pageTitle: "Dashboard"
	 }},
	 // Schools Index page
	{path: '/schools', component: require('../components/SchoolsIndex'), name: 'schoolsIndex',
		meta: {
				title: "All Schools",
				pageTitle: "All Schools"
	}},
	// Schools Show page
	{path: '/schools/:slug', component: require('../components/SchoolsShow'), name: 'schoolsShow'},
	// 404 Page
	{path: '*', component: require('../components/NotFound'), name: '404', meta: {title: 'Error 404'}}
];

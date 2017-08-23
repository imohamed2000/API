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
	{path: '/schools/:slug', component: require('../components/SchoolsShow'),
		children: [
			{path: '', component: require('../components/SchoolAbout'), name: 'schoolsShow'},
			{path: 'edit', component: require('../components/SchoolEdit'), name: 'schoolsEdit'},
			// School users 
			{path: 'users', component: require('../components/SchoolUsersIndex'), name: 'schoolUsersIndex'},
			{path: 'users/:userID', component: require('../components/SchoolUserShow'),
				children: [
					{path: '', component: require('../components/SchoolUserProfile'), name: 'schoolUserProfile'},
					{path: 'edit', component: require('../components/SchoolUserEdit'), name: 'SchoolUserEdit'}
				]
			},
		]
	},
	// 404 Page
	{path: '*', component: require('../components/NotFound'), name: '404', meta: {title: 'Error 404'}}
];

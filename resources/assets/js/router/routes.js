module.exports = [
	{path: '/', component: require('../components/Stats'), name: 'stats'},
	{path: '*', component: require('../components/NotFound'), name: '404'}
];

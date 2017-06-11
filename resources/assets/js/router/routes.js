module.exports = [
		{path: '/', component: require('../components/Example'), name: 'example'},
		{path: '/docs', component: require('../components/Documentation'), name: 'docs'},
		{path: '/docs/:id', component: require('../components/Documentation'), name: 'doc',  children: [
			{path: 'ex', component: require('../components/Example')}
		]},
];

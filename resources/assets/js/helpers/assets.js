export default class{

	/**
	 * Appends a style sheet file to head dynamilcally
	 * @param {string} fileName
	 */
	addStyle(fileName){
		var head = document.head
    		, link = document.createElement('link');

    	link.type = 'text/css';
	    link.rel = 'stylesheet';
	    link.href = fileName;
	    head.appendChild(link);
	}

	/**
	 * Removes style sheet from head
	 * @param  {string} fileName [description]
	 */
	removeStyle(fileName){
		var style= document.querySelector('link[href="'+fileName+'"]');
		var head = document.head;
			head.removeChild(style);
	}

	/**
	 * [addScript description]
	 * @param {[type]} fileName [description]
	 */
	addScript(fileName){
		var head = document.getElementById('_appendScript')
    		, script = document.createElement('script');

    	script.type = 'text/javascript';
	    script.src = fileName;
	    head.appendChild(script);
	}

	/**
	 * [removeScript description]
	 * @param  {[type]} fileName [description]
	 * @return {[type]}          [description]
	 */
	removeScript(fileName){
		var head = document.getElementById('_appendScript');
		var script = document.querySelector('script[src="'+fileName+'"]');
		head.removeChild(script);
	}
}

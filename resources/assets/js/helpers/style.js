// Style : A class to dynamically add/remove style sheets to the page

export default class {

	constructor(){
		this.head = document.head;
	}
	/**
	 * Gets the stylesheet object using the filen name
	 * @param  {string} fileName [the style sheet file name]
	 * @return {object}          [stylesheet link DOM object]
	 */
	getStyle(fileName){
		return document.querySelector('link[href="'+ fileName +'"]');
	}
	/**
	 * Creates a new stylesheet element using the filen name
	 * @param  {string} fileName [the style sheet file name]
	 * @return {object}          [stylesheet link DOM object]
	 */
	createStyle(fileName){
		let link = document.createElement('link');
			link.type = 'text/css';
	    	link.rel = 'stylesheet';
	    	link.href = fileName;
	    return link;
	}
	/**
	 * Add new style to the head section
	 * @param  {string} fileName the style sheet file name
	 * @return {void}
	 */
	pushStyle(fileName){
		this.head.appendChild( this.createStyle(fileName) );
	}

	/**
	 * Removes a style from the head section
	 * @param  {string} fileName the style sheet file name
	 * @return {void}
	 */
	popStyle(fileName){
		this.head.removeChild( this.getStyle(fileName) );
	}
}

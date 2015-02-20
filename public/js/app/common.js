"use strict";

$(function() {
	var rand = function() {
	    return Math.random().toString(36).substr(2); // remove `0.`
	};
	
	var token = function() {
	    return rand() + rand(); // to make it longer
	};
	
	function setUserHash() {
	    localStorage.setItem("userHash", token());
	}
	
	function getUserHash() {
	    localStorage.getItem("userHash");
	}

});
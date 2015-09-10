// Copyright (c) 2006 - 2008 Gabriel Lanzani (http://www.glanzani.com.ar)
// 
// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:
// 
// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
// LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
//
// SEE CHANGELOG FOR A COMPLETE CHANGES OVERVIEW
// VERSION 0.4

Autocompleter.SelectBox = Class.create();
Autocompleter.SelectBox.prototype = Object.extend(new Autocompleter.Base(), {
  initialize: function(select, options) {
  //alert(document.getElementById(select).selectedIndex)
  mywidth=options.width;
  mymargin=options.margin;
  mypadding=options.padding;
  
	this.element = "<input type=\"text\" id=\"" + $(select).id + "_combo\" style=\"margin:"+mymargin+"px;padding:"+mypadding+"px; letter-spacing: 1px; height:15px; width:"+mywidth+"px; opacity:0; float:left; margin-left:-152px;border:0;filter:Alpha(opacity=0);-moz-opacity:0;-khtml-opacity: 0;\"/>"
	this.element2 = "<span id=\""+$(select).id+"_txt\" style=\"margin:"+mymargin+"px;padding:"+mypadding+"px; letter-spacing: 1px; padding-top:2px; height:15px; width:"+mywidth+"px;float:left;margin-bottom:7px;\"></span>"
	//this.element = "<div id=\""+$(select).id+"_txt\"></div><input type=\"text\" id=\"" + $(select).id + "_combo\" style=\"display:none\" />"
	new Insertion.Before(select, this.element2);
  new Insertion.Before(select, this.element);
	
	var inputClasses = Element.classNames(select);
	
	this.update = "<div id=\"" + $(select).id + "_options\" class=\"" + inputClasses + "\"></div>"	
	new Insertion.Before(select, this.update)
			
  this.baseInitialize($(select).id + "_combo", $(select).id + "_options", options);
  //this.baseInitialize($(select).id + "_txt", $(select).id + "_options", options);
  
  this.select = select;
	this.selectOptions = [];
		
	$(this.element.id).setAttribute('readonly','readonly');
	this.element.readOnly = true;
	
	if(this.options.debug) var debugText = 'Debug input ' + this.element.id + ' and div ' + this.update.id + ' created, Autocompleter.Base() initialized\r\n';
	if(!this.options.debug)Element.hide(select);
	//Element.addClassName(this.element.id, this.options.css) ;
	
	Element.addClassName($($(select).id+"_txt").id, this.options.css) ;
	
	var optionList = $(this.select).getElementsByTagName('option');
	
	var nodes = $A(optionList);

	for(i=0; i<nodes.length;i++){
	 tabvalue=nodes[i].value.split("|");
	 value=tabvalue[0];
	 img_src=tabvalue[1];
	
    if(tabvalue.length>1){
		  monHTML=nodes[i].innerHTML+" <img src=\""+img_src+"\">";
		}else{
		  monHTML=nodes[i].innerHTML
		}
		//alert(nodes[i].innerHTML)
		this.selectOptions.push("<li id=\"" + nodes[i].value + "\">" + monHTML + "</li>");
		if (nodes[i].getAttribute("selected")) this.element.value = monHTML
		
		if(this.options.debug) debugText += 'option ' + monHTML + ' added to '+ this.update.id + "\r\n";
	}
	
	Event.observe(this.element, "click", this.activate.bindAsEventListener(this));
	
	//if ($(select).selectedIndex >= 0)this.element.value = $(select).options[$(select).selectedIndex].innerHTML;
  //alert($(select).selectedIndex)
  //alert('ici');
	if ($(select).selectedIndex >= 0){
    
    tabvalue=nodes[$(select).selectedIndex].value.split("|");
    value=tabvalue[0];
    img_src=tabvalue[1];
    if(tabvalue.length>1){
		  monHTML=nodes[$(select).selectedIndex].innerHTML+" <img src=\""+img_src+"\">";
		}else{
		  monHTML=nodes[$(select).selectedIndex].innerHTML
		}
    this.element.value = monHTML;
    $($(select).id+"_txt").innerHTML = monHTML;
	}
	
	var self = this;
	this.options.afterUpdateElement = function(text, li) {
    //alert('ici');
		var optionList = $(select).getElementsByTagName('option');
		var nodes = $A(optionList);

		var opt = nodes.find( function(node){
			return (node.value == li.id);
		});
		
		$(select).selectedIndex=opt.index;
    
    tabvalue=nodes[$(select).selectedIndex].value.split("|");
    value=tabvalue[0];
    img_src=tabvalue[1];
    if(tabvalue.length>1){
		  monHTML=nodes[$(select).selectedIndex].innerHTML+" <img src=\""+img_src+"\">";
		}else{
		  monHTML=nodes[$(select).selectedIndex].innerHTML
		}
    //this.element.value = monHTML;
    $($(select).id+"_txt").innerHTML = monHTML;
    
		//if(self.options.redirect) document.location.href = opt.value;
		if(self.options.redirect) document.location.href = self.options.redirect+opt.value.split("|")[0];
		if(self.options.submit != '') $(self.options.submit).submit();
	}
	
	if(this.options.debug) alert(debugText);
  },

  getUpdatedChoices: function() {
 		this.updateChoices(this.setValues());
  },

  setValues : function(){
		return ("<ul>" + this.selectOptions.join('') + "</ul>");
  },
  
  setOptions: function(options) {
    this.options = Object.extend({
		//MORE OPTIONS TO EXTEND THIS CLASS
		submit		: false, //form Id to submit after change 
		redirect	: false, // redirects to option value
		debug		: false, //show alerts with information
		css			: 'combo'	 //css class for new element 
	}, options || {});
  }
})
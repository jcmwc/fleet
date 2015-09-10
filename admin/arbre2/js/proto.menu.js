/** 
 * @description		prototype.js based context menu
 * @author        Juriy Zaytsev; kangax [at] gmail [dot] com; http://thinkweb2.com/projects/prototype/
 * @version       0.6
 * @date          12/03/07
 * @requires      prototype.js 1.6
*/
if (Object.isUndefined(Proto)) { var Proto = { } }

Proto.Menu = Class.create({
	initialize: function() {
		var e = Prototype.emptyFunction;
		this.ie = Prototype.Browser.IE;
		this.subMenuItems=null;
    this.options = Object.extend({
			selector: '.contextmenu',
			className: 'protoMenu',
			pageOffset: 25,
			fade: false,
			zIndex: 50000,
			beforeShow: e,
			beforeHide: e,
			beforeSelect: e
		}, arguments[0] || { });
		
		this.shim = new Element('iframe', {
			style: 'position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);display:none',
			src: 'javascript:false;',
			frameborder: 0
		});
		
		this.options.fade = this.options.fade && !Object.isUndefined(Effect);
		this.container = new Element('div', { style: 'display:none'});
		this.container.addClassName(this.options.className);
		var list = new Element('ul');
		this.options.menuItems.each(function(item) {
      myli=new Element('li');
      myli.addClassName(item.separator ? 'separator' : '');
      
      myli.insert(
					item.separator 
						? '' 
						: Object.extend(new Element('a', {
							href: '#',
							title: item.name
						}).addClassName((item.className || '') + (item.disabled ? ' disabled' : ' enabled')), { _callback: item.callback })
						.observe('click', this.onClick.bind(this))
						.observe('contextmenu', Event.stop)
						.update(item.name)
				)
			/*
			myli.insert(
        item.separator
        ? '' 
				:Object.extend(new Element('a',{href: '#',title: item.name})))
			*/
			if(item.subMenuItems){
        submenudroit = new Element('div', { style: 'display:none;left:200px;margin-top:-20px;position:relative'});
    		submenudroit.addClassName(this.options.className);
        var sublist = new Element('ul');
    		item.subMenuItems.each(function(subitem) {
    		  //alert(subitem.callback)
    		  //alert(subitem.img+' / '+subitem.name);
    		  if(typeof(subitem.img)!="undefined"){
            mysubli=new Element('li', {style: 'background:url(\''+subitem.img+'\') no-repeat 2px 50%'});
          }else{
            mysubli=new Element('li');
          }
          sublist.insert( 
    				mysubli.insert(
    					subitem.separator 
    						? '' 
    						: Object.extend(new Element('a', {
    							href: '#',
    							title: subitem.name
    						}).addClassName((item.className || '') + (item.disabled ? ' disabled' : ' enabled')), { _callback: subitem.callback })
    						.observe('click', this.onClick.bind(this))
    						.observe('contextmenu', Event.stop)
    						.update(subitem.name)
    				).addClassName(subitem.separator ? 'separator' : '')
    			);
    		}.bind(this));
        /*
        =new Proto.Menu({
          selector: this.options.selector, // context menu will be shown when element with id of "contextArea" is clicked
          className: this.options.className, // this is a class which will be attached to menu container (used for css styling)
          menuItems: item.subMenuItems // array of menu items
        })
        */
        submenudroit.insert(sublist);
        myli.insert(submenudroit);
        myli.observe('mouseover', this.showsubmenu.bind(this,submenudroit));
				myli.observe('mouseout', this.hidesubmenu.bind(this,submenudroit));			
        myli.className = "subelem";
        //alert(myli.className);
      }
      list.insert(myli);
		}.bind(this));
		
		//alert(this.container.innerHTML)
		$(document.body).insert(this.container.insert(list).observe('contextmenu', Event.stop));
		if (this.ie) { $(document.body).insert(this.shim) }
		//alert(this.container.innerHTML);
		
		document.observe('click', function(e) {
			if (this.container.visible() && !e.isRightClick()) {
        this.hide(e);
      }
		}.bind(this));
		/*
		$$(this.options.selector).invoke('observe', Prototype.Browser.Opera ? 'click' : 'contextmenu', function(e){
			if (Prototype.Browser.Opera && !e.ctrlKey) {
				return;
			}
			this.show(e);
		}.bind(this));
		*/
		
	},
	showsubmenu: function(submenu,e) {
	 //alert(e);
    //if(this.submenudroit!=null)
      submenu.show();
	},
  hidesubmenu: function(submenu,e) {
    //if(this.submenudroit!=null)
      submenu.hide();
	},
	hide: function(e){
      //alert('hide');
			this.options.beforeHide(e);
			if (this.ie) this.shim.hide();
			this.container.hide();
  },
	show: function(e) {
		e.stop();
		this.options.beforeShow(e);
		var x = Event.pointer(e).x,
			y = Event.pointer(e).y,
			vpDim = document.viewport.getDimensions(),
			vpOff = document.viewport.getScrollOffsets(),
			elDim = this.container.getDimensions(),
			elOff = {
				left: ((x + elDim.width + this.options.pageOffset) > vpDim.width 
					? (vpDim.width - elDim.width - this.options.pageOffset) : x) + 'px',
				top: ((y - vpOff.top + elDim.height) > vpDim.height && (y - vpOff.top) > elDim.height 
					? (y - elDim.height) : y) + 'px'
			};
		this.container.setStyle(elOff).setStyle({zIndex: this.options.zIndex});
		if (this.ie) {
			this.shim.setStyle(Object.extend(Object.extend(elDim, elOff), {zIndex: this.options.zIndex - 1})).show();
		}
		this.options.fade ? Effect.Appear(this.container, {duration: 0.25}) : this.container.show();
		this.event = e;
		
	},
	onClick: function(e) {
		e.stop();
		if (e.target._callback && !e.target.hasClassName('disabled')) {
			this.options.beforeSelect(e);
			if (this.ie) this.shim.hide();
			this.container.hide();
			e.target._callback(this.event);
		}
	}
})
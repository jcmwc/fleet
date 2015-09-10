function deletelem(obj)
{
if(obj.options&&obj.selectedIndex!=-1){
	if(obj.options[obj.options.selectedIndex].value!="")
	{
		for(i=obj.options.length-1;i>-1;i--)
		{
			if(obj.options[i].selected==true)
				obj.options[i]=null;
		}
	}
	else
		alert("Aucun élément de sélectionné !")
}
}
function deletelem2(obj)
{
	for(i=obj.options.length-1;i>-1;i--)
	{
  		if(obj.options[i].selected==true){
	      obj.options[i]=null;
         break;
      }else
	      obj.options[i]=null;
	}
}
function deletelem3(obj)
{
		for(i=obj.options.length-1;i>-1;i--)
			obj.options[i]=null;
}

function newelem4(obj1,obj2,booldelete)
{
	tabdelete=Array()
		if(obj1.value!="")
		{
			for(i=0;i<obj1.options.length;i++)
			{
				if(obj1.options[i].selected)
				{	
					//if(!existOption(obj1.options[i].value,obj2))	
					//{
						if(!estuneadressemail(obj1.options[i].value)){
							o=new Option(obj1.options[i].text,obj1.options[i].value);
							o.style.color=obj1.options[i].style.color
 							obj2.options[obj2.options.length]=o;
						}
						tabdelete[tabdelete.length]=i
					//}
				}
			}
		}
		else
			alert("Champ vide !");
		obj1.value=""
		if(booldelete==null){
    for(i=tabdelete.length;i>=0;i--)
		{
			obj1.options[tabdelete[i]]=null
		}
    }
}
function newelem3(obj1,obj2)
{
	tabdelete=Array()
		for(i=0;i<obj1.options.length;i++)
		{
			if(!existOption(obj1.options[i].value,obj2))	
			{
				if(!estuneadressemail(obj1.options[i].value)){
					o=new Option(obj1.options[i].text,obj1.options[i].value);
					o.style.color=obj1.options[i].style.color
					obj2.options[obj2.options.length]=o;
				}
				tabdelete[tabdelete.length]=i
			}
		}
    
		for(i=tabdelete.length;i>=0;i--)
		{
			obj1.options[tabdelete[i]]=null
		}
}
function newelem5(obj1,obj2,booldelete)
{
	tabdelete=Array()
   plus=false;
		for(i=0;i<obj1.options.length;i++)
		{
	      if(!existOption(obj1.options[i].value,obj2))	
			{
    			if(obj1.options[i].selected||plus==true)
    			{	
    				o=new Option(obj1.options[i].text,obj1.options[i].value);
    				o.style.backgroundColor=obj1.options[i].style.backgroundColor
    				obj2.options[obj2.options.length]=o;
    				tabdelete[tabdelete.length]=i
                plus=true;
    			}
         }
		}
      if(booldelete==null){
	  		for(i=tabdelete.length;i>=0;i--)
  			{
  				obj1.options[tabdelete[i]]=null
	  		}
        	arraysort(obj2);
      }
}
function newelem6(obj1,obj2)
{
	tabdelete=Array()
   plus=true;
		for(i=0;i<obj1.options.length;i++)
		{
			if(obj1.options[i].selected||plus==true)
			{	
				o=new Option(obj1.options[i].text,obj1.options[i].value);
				o.style.backgroundColor=obj1.options[i].style.backgroundColor
				obj2.options[obj2.options.length]=o;
				tabdelete[tabdelete.length]=i
            plus=false;
			}
		}
		for(i=tabdelete.length;i>=0;i--)
		{
			obj1.options[tabdelete[i]]=null
		}
      arraysort(obj2);
}
function newelem7(obj1,obj2,booldelete)
{
	tabdelete=Array()
   plus=false;
		for(i=0;i<obj1.options.length;i++)
		{
	      if(!existOption(obj1.options[i].value,obj2)&&obj1.options[i].value!=2)	
			{
    			if(obj1.options[i].selected||plus==true)
    			{	
    				o=new Option(obj1.options[i].text,obj1.options[i].value);
    				o.style.backgroundColor=obj1.options[i].style.backgroundColor
    				obj2.options[obj2.options.length]=o;
    				tabdelete[tabdelete.length]=i
    			}
         }
         if(obj1.options[i].selected)
         plus=true;
		}
      if(booldelete==null){
	  		for(i=tabdelete.length;i>=0;i--)
  			{
  				obj1.options[tabdelete[i]]=null
	  		}
        	arraysort(obj2);
      }
}
function newelem8(obj1,obj2,obj3)
{
	tabdelete=Array()
	for(i=0;i<obj1.options.length;i++)
	{
      if(!existOption(obj1.options[i].value,obj2))	
			{
    			if(obj1.options[i].selected)
    			{	
    				o=new Option(obj1.options[i].text,obj1.options[i].value);
    				obj2.options[obj2.options.length]=o;
            //alert(obj3.options.length)
    				o=new Option(obj1.options[i].text,obj1.options[i].value);
    				obj3.options[obj3.options.length]=o;
    				tabdelete[tabdelete.length]=i
    			}
         }
		}
	  		for(i=tabdelete.length;i>=0;i--)
  			{
  				obj1.options[tabdelete[i]]=null
	  		}
}
function newelem9(obj1,obj2,obj3,obj4)
{
	tabdelete=Array()
	tabvalue=Array()
	for(i=0;i<obj1.options.length;i++)
	{
      if(!existOption(obj1.options[i].value,obj2))	
			{
    			if(obj1.options[i].selected)
    			{	
    				o=new Option(obj1.options[i].text,obj1.options[i].value);
    				obj2.options[obj2.options.length]=o;
    				tabdelete[tabdelete.length]=i
            deleteOption(obj1.options[i].value,obj3);
            deleteOption(obj1.options[i].value,obj4);
    			}
      }
	}
 	for(i=tabdelete.length;i>=0;i--)
	{
		obj1.options[tabdelete[i]]=null
 	}
	
}
function arraysort(obj){
	tab=Array();
	tab2=Array();
   nb=obj.options.length;
   for(i=0;i<nb;i++)
	{
   	tab[obj.options[0].value]=Array(obj.options[0].text,obj.options[0].style.backgroundColor)
      tab2[i]=obj.options[0].value;
      obj.options[0]=null;
	}
   tab2.sort(compareNum);
   for(i=0;i<tab2.length;i++){
	   
   	o=new Option(tab[tab2[i]][0],tab2[i]);
		o.style.backgroundColor=tab[tab2[i]][1]
		obj.options[obj.options.length]=o;
   }
}
function compareNum(a,b){return a-b;}
function newelem2(obj1,obj2)
{
	for(i=0;i<obj1.options.length;i++)
	{
		if(!existOption(obj1.options[i].value,obj2))	
		{
			o=new Option(obj1.options[i].text,obj1.options[i].value);
			obj2.options[obj2.options.length]=o;
         obj2.options[obj2.options.length].style.backgroundColor=obj1.options[i].style.backgroundColor
		}
	}
   arraysort(obj2);
}

function selectAll(obj)
{
	for(i=0;i<obj.options.length;i++)
		obj.options[i].selected=true;
}

function existOption(myValue,obj)
{
	for(w=0;w<obj.options.length;w++)
		if(myValue==obj.options[w].value)
			return true;
	return false;
}
function deleteOption(myValue,obj)
{
	for(w=0;w<obj.options.length;w++)
		if(myValue==obj.options[w].value)
	    obj.options[w]=null;
}
function estuneadressemail(monemail)
{
flag=false;
	if(monemail!="")
	{
	longueur=monemail.substring(monemail.lastIndexOf("."),monemail.length).length
		if(monemail.indexOf("@")!=-1&&(longueur==3||longueur==4))
		{
			if(monemail.indexOf("@")<monemail.lastIndexOf(".")+1)
				flag= true;
		}
	}
return flag;
}
function upselect(obj){
  lastindex=obj.options.selectedIndex;
  if(obj.options.selectedIndex!=0){
    tmpobj1=o=new Option(obj.options[lastindex].text,obj.options[lastindex].value);;
    tmpobj2=o=new Option(obj.options[lastindex-1].text,obj.options[lastindex-1].value);;
    //tmpobj2=obj.options[lastindex-1];
    obj.options[lastindex-1]=tmpobj1;
    obj.options[lastindex]=tmpobj2;
    
  }
}
function downselect(obj){
  lastindex=obj.options.selectedIndex;
  if(obj.options.selectedIndex!=0){
    tmpobj1=o=new Option(obj.options[lastindex].text,obj.options[lastindex].value);;
    tmpobj2=o=new Option(obj.options[lastindex+1].text,obj.options[lastindex-1].value);;
    //tmpobj2=obj.options[lastindex-1];
    obj.options[lastindex+1]=tmpobj1;
    obj.options[lastindex]=tmpobj2;
    
  }
}
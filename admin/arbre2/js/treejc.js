//permet de palier au pb de prototype 1.6
Function.prototype.bindAsEventListener = function(object) {
  var __method = this, args = $A(arguments), object = args.shift();
    return function(event) {
      //correction jc
      return __method.apply(object, [( event || window.event)].concat(args).concat($A(arguments)));
    }
}

function funcOpen (branch, response) {
	// Ici tu peux traiter le retour et retourner true si
	// tu veux insérer les enfants, false si tu veux pas
	return true;
}
function funcVerrou(branch,response){
  return true;
}
function contextmenudiv(branch,e){ 
  if(TafelTree.menudroit!=null){
    //alert('ici');
    TafelTree.menudroit.hide(e);
  }
  var myMenuItems = Array();
  var subMenuItems = Array();
  var subMenuItems2 = Array();
  var subMenuItems3 = Array();
  
  if(branch.struct.id=='root1'){
            subMenuItems[subMenuItems.length] = {
              name: 'Article',
              callback: function() {
                //alert('article');
                nouvelarticle();
              }
            };
            subMenuItems[subMenuItems.length] = {
              name: 'Dossier',
              callback: function() {
                //alert('dossier ici');
                nouveaudossier();
              }
            };
            
            myMenuItems[myMenuItems.length] = {
              name: 'Nouveau',
              subMenuItems:subMenuItems
            };
      
            if(branch.tree.cuttedBranches.length>0||branch.tree.copiedBranches.length>0){
              
                myMenuItems[myMenuItems.length] = {
                  separator: true
                };
            
                myMenuItems[myMenuItems.length] = {
                    name: 'Coller',
                    callback: function() {
                      //alert('Coller');
                      //branch.tree.selectedBranches.push(branch);
                      branch.tree.paste();
                    }
                  };
                myMenuItems[myMenuItems.length] = {
                    name: 'Créer un alias',
                    callback: function() {
                      if(branch.tree.copiedBranches.length>0)
                        branch.insertIntoLast(branch.tree.copiedBranches[branch.tree.copiedBranches.length-1].alias());
                      if(branch.tree.cuttedBranches.length>0)
                        branch.insertIntoLast(branch.tree.copiedBranches[branch.tree.cuttedBranches.length-1].alias());
                    }
                  };
              }
  
  } else if (!branch.isRoot&&branch.getAncestor().struct.id!='pb') {
        subMenuItems[subMenuItems.length] = {
          name: 'Article',
          callback: function() {
            //alert('article');
            nouvelarticle();
          }
        };
        subMenuItems[subMenuItems.length] = {
          name: 'Dossier',
          callback: function() {
            //alert('dossier ici');
            nouveaudossier();
          }
        };
        
      //affichage du menu
      if(branch.struct.alias=='0'){
          myMenuItems[myMenuItems.length] = {
            name: 'Nouveau',
            subMenuItems:subMenuItems
          };
          myMenuItems[myMenuItems.length] = {
            separator: true
          };
      }
      
        /*
        callback: function() {
           TafelTree.submenudroit.show(e,180);
        }*/
    
    //a faire plus tard
    /*
    if(branch.struct.canhavechildren){
      myMenuItems[myMenuItems.length] = {
          name: 'Explorer',
          callback: function() {
            alert('Explorer');
          }
        };
    }*/
    myMenuItems[myMenuItems.length] = {
        name: 'Informations',
        callback: function() {
          alert('Informations');
        }
      };
    
    if(branch.struct.verrou){
      myMenuItems[myMenuItems.length] = {
          name: 'Déverrouiller',
          callback: function() {
            branch.chgVerrou();
          }
        };
    }else{
      myMenuItems[myMenuItems.length] = {
          name: 'Verrouiller',
          callback: function() {
            branch.chgVerrou();
          }
        };
    }
    
    /*
    subMenuItems2[subMenuItems2.length] = {
      name: 'Article',
      callback: function() {
        //alert('article');
        nouvelarticle();
      }
    };
    subMenuItems2[subMenuItems2.length] = {
      name: 'Dossier',
      callback: function() {
        //alert('dossier ici');
        nouveaudossier();
      }
    };*/
    
    myMenuItems[myMenuItems.length] = {
        name: 'Modifier',
        subMenuItems:subMenuItems2
        /*callback: function() {
          alert('Modifier');
        }*/
      };
    myMenuItems[myMenuItems.length] = {
        name: 'Supprimer',
        callback: function() {
          //branch.tree.selectedBranches.push(branch);
          branch._setDropAjax(tree.getBranchById('pb'), 0, 0, 0, null);
        }
      };
    myMenuItems[myMenuItems.length] = {
        name: 'Renommer',
        callback: function() {
          branch.setDblClick(e);
        }
      };
    myMenuItems[myMenuItems.length] = {
        separator: true
      };
    myMenuItems[myMenuItems.length] = {
        name: 'Copier',
        callback: function() {
          branch.tree.selectedBranches.push(branch);
          tree.copy();
        }
      };
    myMenuItems[myMenuItems.length] = {
        name: 'Couper',
        callback: function() {
          branch.tree.selectedBranches.push(branch);
          branch.tree.cut();
        }
      };
    if(branch.tree.cuttedBranches.length>0||branch.tree.copiedBranches.length>0){
      myMenuItems[myMenuItems.length] = {
          name: 'Coller',
          callback: function() {
            //alert('Coller');
            //branch.tree.selectedBranches.push(branch);
            branch.tree.paste();
          }
        };
      myMenuItems[myMenuItems.length] = {
          name: 'Créer un alias',
          callback: function() {
            if(branch.tree.copiedBranches.length>0)
              branch.insertIntoLast(branch.tree.copiedBranches[branch.tree.copiedBranches.length-1].alias());
            if(branch.tree.cuttedBranches.length>0)
              branch.insertIntoLast(branch.tree.copiedBranches[branch.tree.cuttedBranches.length-1].alias());
          }
        };
    }
    if(branch.pos>0||branch.tree.selectedBranches.length==2||branch.getParent().children.length-1!=branch.pos){
      myMenuItems[myMenuItems.length] = {
          separator: true
        };
      //a faire plus tard
      /*
      if(branch.tree.selectedBranches.length==2){
        myMenuItems[myMenuItems.length] = {
            name: 'Intervertir la position',
            callback: function() {
              alert('Forward function called');
            }
          };
      }*/
      if(branch.pos>0){
        myMenuItems[myMenuItems.length] = {
            name: 'En premier',
            callback: function() {
              branch._setDropAjax(branch.getParent().children[0], 1, 0, 0, null);
            }
          };
        myMenuItems[myMenuItems.length] = {
            name: 'Plus haut',
            callback: function() {
              branch._setDropAjax(branch.getParent().children[branch.pos-1], 1, 0, 0, null);
            }
          };
      }
      if(branch.getParent().children.length-1!=branch.pos){
        myMenuItems[myMenuItems.length] = {
            name: 'Plus bas',
            callback: function() {
              //alert('Plus bas');
              /*if(branch.pos==branch.getParent().children.length-1){
                branch._setDropAjax(branch.getParent(), 0, 0, 0, null);
              }else{
                branch._setDropAjax(branch.getParent().children[branch.pos+1], 1, 0, 0, null);
              }*/
              branch.movedown();
            }
          };
        myMenuItems[myMenuItems.length] = {
            name: 'En dernier',
            callback: function() {
              branch._setDropAjax(branch.getParent(), 0, 0, 0, null);
            }
          };
      }
    }
      /*myMenuItems[myMenuItems.length] = {
        separator: true
      };*/
      /*myMenuItems[myMenuItems.length] = {
        name: 'Droits',
        callback: function() {
          alert('Droits');
        }
      };*/
  }
  if(branch.struct.id=='pb'){
    myMenuItems[myMenuItems.length] = {
        name: 'Vider la corbeille',
        callback: function() {
          for(i=0;i<branch.children.length;i++){
            branch.children[i].finishDelete();
          }
        }
      };
    //a faire plus tard
    /*
    myMenuItems[myMenuItems.length] = {
        name: 'Tout restaurer',
        callback: function() {
          alert('Tout restaurer');
        }
      };
  */
  //}else if(branch.getAncestor().struct.id=='pb'){
  }else if(branch.getParent()&&branch.getParent().struct.id=='pb'){
    myMenuItems[myMenuItems.length] = {
        name: 'Restaurer',
        callback: function() {
          branch.restore();
        }
      };
    myMenuItems[myMenuItems.length] = {
        name: 'Suppression définitive',
        callback: function() {
          branch.finishDelete();
        }
      };
    myMenuItems[myMenuItems.length] = {
        name: 'Informations',
        callback: function() {
          alert('Informations');
        }
      };
  }
  if(myMenuItems.length>0){
    TafelTree.menudroit=new Proto.Menu({
      selector: '#test', // context menu will be shown when element with id of "contextArea" is clicked
      className: 'menu desktop', // this is a class which will be attached to menu container (used for css styling)
      menuItems: myMenuItems // array of menu items
    })
    TafelTree.menudroit.show(e);
    /*
    TafelTree.submenudroit=new Proto.Menu({
      selector: '#test', // context menu will be shown when element with id of "contextArea" is clicked
      className: 'menu desktop', // this is a class which will be attached to menu container (used for css styling)
      menuItems: subMenuItems // array of menu items
    })*/
  }
  //alert('contextmenudiv');
  //alert(branch)
  return false;
}
function funcEdit(branch){
  return true;
}
function funcDrop3 (move, drop, response, finished) {
	// On vérifie avant que le drop soit fait. A ce moment là
	// la requête Ajax est effectuée, mais pas le drop.
	if (!finished) {
		// On évalue la réponse Ajax. L'objet contient donc
		// une propriété "ok" et une autre "msg"
		var obj = eval(response);
		if (!obj.ok) {
			alert ('Problème : ' + obj.msg);
			return false;
		}
	}
	//alert('ici');
	return true;
}

function glu (branch) {
  return (branch.children.length > 0) ? true : false;
}
function testParent (branch) {
		var p = tree.getBranches(glu);
		var str = '';
		for (var i = 0; i < p.length; i++) {
			str += p[i].getText() + ' : ' + p[i].children.length + "\n";
		}
		//alert(str);
}
function effet () {
	var branch = tree.getBranchById('child1');
	branch.refreshChildren();
}
function drop () {
	return true;
}

function funcFinishDelete(){
  return true;
}
function funcRestore(){
  return true;
}
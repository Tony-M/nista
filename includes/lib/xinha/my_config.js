/* This compressed file is part of Xinha. For uncomressed sources, forum, and bug reports, go to xinha.org */
xinha_editors=null;
xinha_init=null;
xinha_config=null;
xinha_plugins=null;
xinha_init=xinha_init?xinha_init:function(){
xinha_editors=xinha_editors?xinha_editors:["text"];
xinha_plugins=xinha_plugins?xinha_plugins:["CharacterMap","ContextMenu","ListType","Stylist","Linker","SuperClean","TableOperations" , "ImageManager"];
//xinha_plugins=xinha_plugins?xinha_plugins:["CharacterMap","ContextMenu","ListType","Stylist","Linker","SuperClean","TableOperations" ];
if(!Xinha.loadPlugins(xinha_plugins,xinha_init)){
return;
}
xinha_config=xinha_config?xinha_config():new Xinha.Config();
xinha_config.pageStyleSheets=[_editor_url+"../../css/userstyle.css"];









xinha_editors=Xinha.makeEditors(xinha_editors,xinha_config,xinha_plugins);
Xinha.startEditors(xinha_editors);
};
Xinha._addEvent(window,"load",xinha_init);


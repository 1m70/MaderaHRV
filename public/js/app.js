var blueprint3d = null;
var aGlobal = null;
var anItem = null;
var aWall = null;
var aFloor = null;
var aCameraRange = null;
var gui = null;
var globalPropFolder = null;
var itemPropFolder = null;
var wallPropFolder = null;
var floorPropFolder = null;
var cameraPropFolder = null;
var selectionsFolder = null;

var myhome = '{"floorplan":{"corners":{"71d4f128-ae80-3d58-9bd2-711c6ce6cdf2":{"x":0,"y":0,"elevation":4},"f90da5e3-9e0e-eba7-173d-eb0b071e838e":{"x":0,"y":5,"elevation":2.5},"da026c08-d76a-a944-8e7b-096b752da9ed":{"x":5,"y":5,"elevation":2.5},"4e3d65cb-54c0-0681-28bf-bddcc7bdb571":{"x":5,"y":0,"elevation":4}},"walls":[{"corner1":"71d4f128-ae80-3d58-9bd2-711c6ce6cdf2","corner2":"f90da5e3-9e0e-eba7-173d-eb0b071e838e","frontTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0},"backTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0}},{"corner1":"f90da5e3-9e0e-eba7-173d-eb0b071e838e","corner2":"da026c08-d76a-a944-8e7b-096b752da9ed","frontTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0},"backTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0}},{"corner1":"da026c08-d76a-a944-8e7b-096b752da9ed","corner2":"4e3d65cb-54c0-0681-28bf-bddcc7bdb571","frontTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0},"backTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0}},{"corner1":"4e3d65cb-54c0-0681-28bf-bddcc7bdb571","corner2":"71d4f128-ae80-3d58-9bd2-711c6ce6cdf2","frontTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0},"backTexture":{"url":"rooms/textures/wallmap.png","stretch":true,"scale":0}}],"rooms":{"f90da5e3-9e0e-eba7-173d-eb0b071e838e,71d4f128-ae80-3d58-9bd2-711c6ce6cdf2,4e3d65cb-54c0-0681-28bf-bddcc7bdb571,da026c08-d76a-a944-8e7b-096b752da9ed":{"name":"A New Room"}},"wallTextures":[],"floorTextures":{},"newFloorTextures":{},"carbonSheet":{"url":"","transparency":1,"x":0,"y":0,"anchorX":0,"anchorY":0,"width":0.01,"height":0.01}},"items":[]}';



/*
 * Floorplanner controls
 */

var ViewerFloorplanner = function(blueprint3d)
{
	var canvasWrapper = '#floorplanner';
	// buttons
	var move = '#move';
	var remove = '#delete';
	var draw = '#draw';

	var activeStlye = 'btn-primary disabled';

	this.floorplanner = blueprint3d.floorplanner;
	var scope = this;
	function init()
	{
		$( window ).resize( scope.handleWindowResize );

		scope.handleWindowResize();

		scope.floorplanner.addEventListener(BP3DJS.EVENT_MODE_RESET, function(mode)
		{
			$(draw).removeClass(activeStlye);
			$(remove).removeClass(activeStlye);
			$(move).removeClass(activeStlye);

			if (mode == BP3DJS.floorplannerModes.MOVE)
			{
				$(move).addClass(activeStlye);
			}
			else if (mode == BP3DJS.floorplannerModes.DRAW)
			{
				$(draw).addClass(activeStlye);
			}
			else if (mode == BP3DJS.floorplannerModes.DELETE)
			{
				$(remove).addClass(activeStlye);
			}

			if (mode == BP3DJS.floorplannerModes.DRAW)
			{
				$("#draw-walls-hint").show();
				scope.handleWindowResize();
			}
			else
			{
				$("#draw-walls-hint").hide();
			}
		});

		$(move).click(function()
		{
			scope.floorplanner.setMode(BP3DJS.floorplannerModes.MOVE);
		});

		$(draw).click(function()
		{
			scope.floorplanner.setMode(BP3DJS.floorplannerModes.DRAW);
		});

		$(remove).click(function()
		{
			scope.floorplanner.setMode(BP3DJS.floorplannerModes.DELETE);
		});
	}

	this.updateFloorplanView = function() {
		scope.floorplanner.reset();
	}

	this.handleWindowResize = function() {
		$(canvasWrapper).height(window.innerHeight - $(canvasWrapper).offset().top);

		/* console.log(window.innerHeight - $(canvasWrapper).offset().to); */

		scope.floorplanner.resizeView();
	};
	init();
};

var mainControls = function(blueprint3d)
{
	var blueprint3d = blueprint3d;

	function newDesign()
	{
		blueprint3d.model.loadSerialized(myhome);
	}

	function loadDesign()
	{
		files = $("#loadFile").get(0).files;
		if(files.length == 0)
		{
			files = $("#loadFile2d").get(0).files;
		}
		var reader  = new FileReader();
		reader.onload = function(event) {
			var data = event.target.result;

			console.log(data);

			blueprint3d.model.loadSerialized(data);
		}
		reader.readAsText(files[0]);
	}

	function loadDesignAjax()
	{
		id = document.getElementById("plan").value;

		$.ajax({
			url: "/planLoadAjax",
			method: "POST",
			data: {
				dataId: id
			}
		}).success(function(response){
			if(response.status){
				window.location.replace("http://127.0.0.1:8000/plan/" + id + "/edit")
			} else {
				console.log("erreur lors de l'insetion");
			}
		}).error(function(e){
			console.log("Tu es dans l'erreur");
		});
	}

	function saveDesign() {
		var data = blueprint3d.model.exportSerialized();
		var jsonObj = $.parseJSON(data);

		console.log(jsonObj.floorplan.corners['4e3d65cb-54c0-0681-28bf-bddcc7bdb571']);

		var a = window.document.createElement('a');
		var blob = new Blob([data], {type : 'text'});
		a.href = window.URL.createObjectURL(blob);
		a.download = 'design.blueprint3d';
		document.body.appendChild(a)
		a.click();
		document.body.removeChild(a)
	}

	function saveDesignAjax() {
		var data = blueprint3d.model.exportSerialized();

		var jsonObj = $.parseJSON(data);
		var wallsJson = jsonObj.floorplan.walls;
		var cornersJson = jsonObj.floorplan.corners;

		aWallResult = [];
		wallsJson.forEach(function (elementWall) {

			pointA = [cornersJson[elementWall.corner1].x, cornersJson[elementWall.corner1].y];
			pointB = [cornersJson[elementWall.corner2].x, cornersJson[elementWall.corner2].y];

			wallLength = Math.sqrt( Math.pow(pointB[0] - pointA[0], 2) + Math.pow(pointB[1] - pointA[1], 2) );

			console.log(wallLength.toFixed(2));
			console.log("nameMur")

			aWallResult.push(wallLength);
		});
		id = document.getElementById("plan").value;

		$.ajax({
            url: "/planAjax",
            method: "POST",
            data: {
            	dataParam: data,
				dataId: id,
				aResultWall: aWallResult
            }
        }).success(function(response){
        	if(response.status){
				window.location.replace("http://127.0.0.1:8000/plan/" + id + "/edit")
			} else {
        		console.log("erreur lors de l'insetion");
			}
        }).error(function(e){
            console.log("Tu es dans l'erreur");
        });
	}


	function saveGLTF()
	{
		blueprint3d.three.exportForBlender();
	}

	function saveGLTFCallback(o)
	{
		var data = o.gltf;
		var a = window.document.createElement('a');
		var blob = new Blob([data], {type : 'text'});
		a.href = window.URL.createObjectURL(blob);
		a.download = 'design.gltf';
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);
	}

	function saveMesh() {
		var data = blueprint3d.model.exportMeshAsObj();
		var a = window.document.createElement('a');
		var blob = new Blob([data], {type : 'text'});
		a.href = window.URL.createObjectURL(blob);
		a.download = 'design.obj';
		document.body.appendChild(a)
		a.click();
		document.body.removeChild(a)
	}

	function init() {

		$("#new").click(newDesign);
		$("#new2d").click(newDesign);
		$("#loadFile").change(loadDesign);
		$("#saveFile").click(saveDesign);

		$("#loadFile2d").change(loadDesign);
		$("#saveFile2d").click(saveDesignAjax);

		$("#saveMesh").click(saveMesh);
		$("#saveGLTF").click(saveGLTF);
		blueprint3d.three.addEventListener(BP3DJS.EVENT_GLTF_READY, saveGLTFCallback);
	}

	init();
}

var GlobalProperties = function()
{
	this.name = 'Global';
	//a - feet and inches, b = inches, c - cms, d - millimeters, e - meters
	this.units = {a:false, b:false, c:false, d:false, e:true};
	this.unitslabel = {a:BP3DJS.dimFeetAndInch, b:BP3DJS.dimInch, c:BP3DJS.dimCentiMeter, d:BP3DJS.dimMilliMeter, e:BP3DJS.dimMeter};
	this.guiControllers = null;

	this.setUnit = function(unit)
	{
		for (let param in this.units)
		{
			this.units[param] = false;
		}
		this.units[unit] = true;

		BP3DJS.Configuration.setValue(BP3DJS.configDimUnit, this.unitslabel[unit]);

		console.log(this.units, this.unitslabel[unit], BP3DJS.Configuration.getStringValue(BP3DJS.configDimUnit));

//		globalPropFolder = getGlobalPropertiesFolder(gui, aGlobal, floorplanner);
		var view2df = construct2dInterfaceFolder(globalPropFolder, aGlobal, blueprint3d.floorplanner);

		blueprint3d.floorplanner.view.draw();
		for (var i in this.guiControllers) // Iterate over gui controllers to update the values
		{
			this.guiControllers[i].updateDisplay();
		}
	}

	this.setGUIControllers = function(guiControls)
	{
		this.guiControllers = guiControls;
	}
}

var CameraProperties = function()
{
	this.ratio = 1;
	this.ratio2 = 1;
	this.locked = false;
	this.three = null;

	this.change = function()
	{
		if(this.three)
		{
			this.three.changeClippingPlanes(this.ratio, this.ratio2);
		}
	}

	this.changeLock = function()
	{
		if(this.three)
		{
			this.three.lockView(!this.locked);
		}
	}

	this.reset = function()
	{
		if(this.three)
		{
			this.three.resetClipping();
		}
	}
}

var CornerProperties = function(corner, gui)
{
	var scope = this;
	this.x = BP3DJS.Dimensioning.cmToMeasureRaw(corner.x);
	this.y = BP3DJS.Dimensioning.cmToMeasureRaw(corner.y);
	this.elevation = BP3DJS.Dimensioning.cmToMeasureRaw(corner.elevation);
	this.gui = gui;
	this.corner = corner;

	function onEvent()
	{
		scope.x = BP3DJS.Dimensioning.cmToMeasureRaw(scope.corner.x);
		scope.y = BP3DJS.Dimensioning.cmToMeasureRaw(scope.corner.y);
		scope.elevation = BP3DJS.Dimensioning.cmToMeasureRaw(scope.corner.elevation);
		scope.xcontrol.updateDisplay();
		scope.ycontrol.updateDisplay();
		scope.elevationcontrol.updateDisplay();
	}

	function onChangeX()
	{
		scope.corner.x = BP3DJS.Dimensioning.cmFromMeasureRaw(scope.x);
	}
	function onChangeY()
	{
		scope.corner.y = BP3DJS.Dimensioning.cmFromMeasureRaw(scope.y);
	}
	function onChangeElevation()
	{
		scope.corner.elevation = BP3DJS.Dimensioning.cmFromMeasureRaw(scope.elevation);
	}

	this.corner.addEventListener(BP3DJS.EVENT_CORNER_ATTRIBUTES_CHANGED, onEvent);
//	this.corner.addEventListener(BP3DJS.EVENT_MOVED, onEvent);

	this.f = gui.addFolder('Current Corner');
	this.xcontrol = f.add(this, 'x').name(`x(${BP3DJS.Configuration.getStringValue(BP3DJS.configDimUnit)})`).step(0.01).onChange(()=>{onChangeX()});
	this.ycontrol = f.add(this, 'y').name(`y(${BP3DJS.Configuration.getStringValue(BP3DJS.configDimUnit)})`).step(0.01).onChange(()=>{onChangeY()});
	this.elevationcontrol = f.add(this, 'elevation').name(`Elevation(${BP3DJS.Configuration.getStringValue(BP3DJS.configDimUnit)})`).min(0).step(0.01).onChange(()=>{onChangeElevation()});


	return this.f;
}

var RoomProperties = function(room, gui)
{
	var scope = this;
	this.gui = gui;
	this.room = room;
	this.f = gui.addFolder('Current Room');
	this.namecontrol = f.add(room, 'name').name("Name");
	return this.f;
}

var Wall2DProperties = function(wall2d, gui)
{
	var scope = this;
	this.gui = gui;
	this.wall2d = wall2d;
	this.walltype = 'Straight';
	this.walllength = BP3DJS.Dimensioning.cmToMeasureRaw( wall2d.wallSize);
	function onChangeWallType()
	{
		if(scope.walltype == 'Straight')
		{
			scope.wall2d.wallType = BP3DJS.WallTypes.STRAIGHT;
		}
		else if(scope.walltype == 'Curved')
		{
			scope.wall2d.wallType = BP3DJS.WallTypes.CURVED;

		}
		blueprint3d.floorplanner.view.draw();
	}

	function onChangeWallLength()
	{
		scope.wall2d.wallSize = BP3DJS.Dimensioning.cmFromMeasureRaw(scope.walllength);
		console.log(scope.wall.wallSize);
		blueprint3d.floorplanner.view.draw();
	}


	this.options = ['Straight', 'Curved'];
	if(this.wall2d.wallType == BP3DJS.WallTypes.CURVED)
	{
		this.walltype = 'Curved';
	}
	this.f = gui.addFolder('Current Wall 2D');
	this.typecontrol = f.add(this, 'walltype', this.options).name("Wall Type").onChange(()=>{onChangeWallType()});
	if(this.wall2d.wallType == BP3DJS.WallTypes.STRAIGHT)
	{
		this.lengthcontrol = f.add(this, 'walllength').name("Wall Length").onChange(()=>{onChangeWallLength()});
	}
	return this.f;
}

var ItemProperties = function(gui)
{
	this.name = 'an item';
	this.width = 10;
	this.height = 10;
	this.depth = 10;
	this.fixed = false;
	this.currentItem = null;
	this.guiControllers = null;
	this.gui = gui;
	this.materialsfolder = null;
	this.materials = {};
	this.totalmaterials = -1;
	this.proportionalsize = false;
	this.changingdimension = 'w';

	this.setGUIControllers = function(guiControls)
	{
		this.guiControllers = guiControls;
	}

	this.setItem = function(item)
	{
		this.currentItem = item;
		if(this.materialsfolder)
		{
			this.gui.removeFolder(this.materialsfolder.name);
		}
		if(item)
		{
			var scope = this;
			var material = item.material;
			this.name = item.metadata.itemName;
			this.width = BP3DJS.Dimensioning.cmToMeasureRaw(item.getWidth());
			this.height = BP3DJS.Dimensioning.cmToMeasureRaw(item.getHeight());
			this.depth = BP3DJS.Dimensioning.cmToMeasureRaw(item.getDepth());
			this.fixed = item.fixed;
			this.proportionalsize = item.getProportionalResize();

			for (var i in this.guiControllers) // Iterate over gui controllers to update the values
			{
				this.guiControllers[i].updateDisplay();
			}

			this.materialsfolder =  this.gui.addFolder('Materials');
			this.materials = {};
			if(material.length)
			{
				this.totalmaterials = material.length;
				for (var i=0;i<material.length;i++)
				{
					this.materials['mat_'+i] = '#'+material[i].color.getHexString();
					var matname = (material[i].name) ? material[i].name : 'Material '+(i+1);
					var ccontrol = this.materialsfolder.addColor(this.materials, 'mat_'+i).name(matname).onChange(()=>{scope.dimensionsChanged()});
				}
				return;
			}
			this.totalmaterials = 1;
			var matname = (material.name) ? material.name : 'Material 1';
			this.materials['mat_0'] = '#'+material.color.getHexString();
			var ccontrol = this.materialsfolder.addColor(this.materials, 'mat_0').name(matname).onChange(()=>{scope.dimensionsChanged()});
			return;
		}
		this.name = 'None';
		return;
	}

	this.dimensionsChanged = function()
	{
		if(this.currentItem)
		{
			var item = this.currentItem;

			var ow = BP3DJS.Dimensioning.cmToMeasureRaw(item.getWidth());
			var oh = BP3DJS.Dimensioning.cmToMeasureRaw(item.getHeight());
			var od = BP3DJS.Dimensioning.cmToMeasureRaw(item.getDepth());

			var h = BP3DJS.Dimensioning.cmFromMeasureRaw(this.height);
			var w = BP3DJS.Dimensioning.cmFromMeasureRaw(this.width);
			var d = BP3DJS.Dimensioning.cmFromMeasureRaw(this.depth);

			this.currentItem.resize(h,w,d);

			if( w != ow)
			{
				this.height = BP3DJS.Dimensioning.cmToMeasureRaw(item.getHeight());
				this.depth = BP3DJS.Dimensioning.cmToMeasureRaw(item.getDepth());
			}

			if( h != oh)
			{
				this.width = BP3DJS.Dimensioning.cmToMeasureRaw(item.getWidth());
				this.depth = BP3DJS.Dimensioning.cmToMeasureRaw(item.getDepth());
			}

			if( d != od)
			{
				this.width = BP3DJS.Dimensioning.cmToMeasureRaw(item.getWidth());
				this.height = BP3DJS.Dimensioning.cmToMeasureRaw(item.getHeight());
			}
			for (var i=0;i<this.totalmaterials;i++)
			{
				this.currentItem.setMaterialColor(this.materials['mat_'+i], i);
			}

			this.guiControllers.forEach((control)=>{control.updateDisplay()}); // Iterate over gui controllers to update the values
		}
	}

	this.proportionFlagChange = function()
	{
		if(this.currentItem)
		{
			this.currentItem.setProportionalResize(this.proportionalsize);
		}
	}

	this.lockFlagChanged = function()
	{
		if(this.currentItem)
		{
			this.currentItem.setFixed(this.fixed);
		}
	}

	this.deleteItem = function()
	{
		if(this.currentItem)
		{
			this.currentItem.remove();
			this.setItem(null);
		}
	}
}

var WallProperties = function()
{
	this.textures = [
		['rooms/textures/wallmap.png', true, 1], ['rooms/textures/wallmap_yellow.png', true, 1],
		['rooms/textures/light_brick.jpg', false, 50], ['rooms/textures/marbletiles.jpg', false, 300],
		['rooms/textures/light_brick.jpg', false, 100], ['rooms/textures/light_fine_wood.jpg', false, 300],
		['rooms/textures/hardwood.png', false, 300]];

	this.floormaterialname = 0;
	this.wallmaterialname = 0;

	this.forAllWalls = false;

	this.currentWall = null;
	this.currentFloor = null;

	this.wchanged = function()
	{
		if(this.currentWall)
		{
			this.currentWall.setTexture(this.textures[this.wallmaterialname][0], this.textures[this.wallmaterialname][1], this.textures[this.wallmaterialname][2]);
		}
		if(this.currentFloor && this.forAllWalls)
		{
			this.currentFloor.setRoomWallsTexture(this.textures[this.wallmaterialname][0], this.textures[this.wallmaterialname][1], this.textures[this.wallmaterialname][2]);
		}
	}

	this.fchanged = function()
	{
		if(this.currentFloor)
		{
			this.currentFloor.setTexture(this.textures[this.floormaterialname][0], this.textures[this.floormaterialname][1], this.textures[this.floormaterialname][2]);
		}
	}


	this.setWall = function(wall)
	{
		this.currentWall = wall;
	}

	this.setFloor = function(floor)
	{
		this.currentFloor = floor;
	}
}

function addBlueprintListeners(blueprint3d)
{
	var three = blueprint3d.three;
	var currentFolder = undefined;

	function closeCurrent3DSelectionFolders()
	{
		if(itemPropFolder && itemPropFolder != null)
		{
			itemPropFolder.close();
			selectionsFolder.removeFolder(itemPropFolder.name);
		}
		if(wallPropFolder && wallPropFolder != null)
		{
			wallPropFolder.close();
			selectionsFolder.removeFolder(wallPropFolder.name);
		}
	}
	function wallClicked(wall)
	{
		closeCurrent3DSelectionFolders();

		aWall = new WallProperties();
		aWall.setWall(wall);
		aWall.setFloor(null);
		wallPropFolder = getWallAndFloorPropertiesFolder(selectionsFolder, aWall);
//		selectionsFolder.addFolder(wallPropFolder);

		wallPropFolder.open();
		selectionsFolder.open();
	}

	function floorClicked(floor)
	{
		closeCurrent3DSelectionFolders();

		aWall = new WallProperties();
		aWall.setFloor(floor);
		aWall.setWall(null);

		wallPropFolder = getWallAndFloorPropertiesFolder(selectionsFolder, aWall);
//		selectionsFolder.addFolder(wallPropFolder);

		wallPropFolder.open();
		selectionsFolder.open();
	}

	function itemSelected(item)
	{
		closeCurrent3DSelectionFolders();

		anItem = new ItemProperties(selectionsFolder, item);
//		anItem.setItem(item);

		itemPropFolder = getItemPropertiesFolder(selectionsFolder, anItem);
//		selectionsFolder.addFolder(itemPropFolder);

		itemPropFolder.open();
		selectionsFolder.open();

	}
	function itemUnselected()
	{
		closeCurrent3DSelectionFolders();
		if(anItem!=null)
		{
			anItem.setItem(undefined);
		}
	}

	three.addEventListener(BP3DJS.EVENT_ITEM_SELECTED, function(o){itemSelected(o.item);});
	three.addEventListener(BP3DJS.EVENT_ITEM_UNSELECTED, function(o){itemUnselected();});
	three.addEventListener(BP3DJS.EVENT_WALL_CLICKED, (o)=>{wallClicked(o.item);});
	three.addEventListener(BP3DJS.EVENT_FLOOR_CLICKED, (o)=>{floorClicked(o.item);});
	three.addEventListener(BP3DJS.EVENT_FPS_EXIT, ()=>{$('#showDesign').trigger('click')});

	function echoEvents(o)
	{
//    	console.log(o.type, o.item);
	}

	function addGUIFolder(o)
	{
//    	console.log(o.type, o.item);
		if(currentFolder)
		{
			selectionsFolder.removeFolder(currentFolder.name);
		}
		if(o.type == BP3DJS.EVENT_CORNER_2D_CLICKED)
		{
			currentFolder = CornerProperties(o.item, selectionsFolder);//getCornerPropertiesFolder(gui, o.item);
		}
		else if(o.type == BP3DJS.EVENT_ROOM_2D_CLICKED)
		{
			currentFolder = RoomProperties(o.item, selectionsFolder);//getRoomPropertiesFolder(gui, );
		}
		else if(o.type == BP3DJS.EVENT_WALL_2D_CLICKED)
		{
			currentFolder = Wall2DProperties(o.item, selectionsFolder);
		}
		if(currentFolder)
		{
			currentFolder.open();
			selectionsFolder.open();
		}
	}

	var model_floorplan = blueprint3d.model.floorplan;
	model_floorplan.addEventListener(BP3DJS.EVENT_CORNER_2D_DOUBLE_CLICKED, echoEvents);
	model_floorplan.addEventListener(BP3DJS.EVENT_WALL_2D_DOUBLE_CLICKED, echoEvents);
	model_floorplan.addEventListener(BP3DJS.EVENT_ROOM_2D_DOUBLE_CLICKED, echoEvents);

	model_floorplan.addEventListener(BP3DJS.EVENT_NOTHING_CLICKED, addGUIFolder);
	model_floorplan.addEventListener(BP3DJS.EVENT_CORNER_2D_CLICKED, addGUIFolder);
	model_floorplan.addEventListener(BP3DJS.EVENT_WALL_2D_CLICKED, addGUIFolder);
	model_floorplan.addEventListener(BP3DJS.EVENT_ROOM_2D_CLICKED, addGUIFolder);

	model_floorplan.addEventListener(BP3DJS.EVENT_CORNER_2D_HOVER, echoEvents);
	model_floorplan.addEventListener(BP3DJS.EVENT_WALL_2D_HOVER, echoEvents);
	model_floorplan.addEventListener(BP3DJS.EVENT_ROOM_2D_HOVER, echoEvents);

	model_floorplan.addEventListener(BP3DJS.EVENT_CORNER_ATTRIBUTES_CHANGED, echoEvents);
	model_floorplan.addEventListener(BP3DJS.EVENT_WALL_ATTRIBUTES_CHANGED, echoEvents);
	model_floorplan.addEventListener(BP3DJS.EVENT_ROOM_ATTRIBUTES_CHANGED, echoEvents);


	function deleteEvent(evt)
	{
		console.log('DELETED ', evt);
	}

	model_floorplan.addEventListener(BP3DJS.EVENT_DELETED, deleteEvent);

	BP3DJS.Configuration.setValue(BP3DJS.configSystemUI, false);


// three.skybox.toggleEnvironment(this.checked);
// currentTarget.setTexture(textureUrl, textureStretch, textureScale);
// three.skybox.setEnvironmentMap(textureUrl);
}

function getCornerPropertiesFolder(gui, corner)
{
	var f = gui.addFolder('Current Corner');
	var xcontrol = f.add(corner, 'x').name("x").step(0.01);
	var ycontrol = f.add(corner, 'y').name("y").step(0.01);
	var elevationctonrol = f.add(corner, 'elevation').name("Elevation").step(0.01);
	return f;
}

function getRoomPropertiesFolder(gui, room)
{
	var f = gui.addFolder('Current Room');
	var namecontrol = f.add(corner, 'name').name("Name");
	return f;
}

function getCameraRangePropertiesFolder(gui, camerarange)
{
	var f = gui.addFolder('Camera Limits');
	var ficontrol = f.add(camerarange, 'ratio', -1, 1).name("Range").step(0.01).onChange(function(){camerarange.change()});
	var ficontrol2 = f.add(camerarange, 'ratio2', -1, 1).name("Range 2").step(0.01).onChange(function(){camerarange.change()});
	var flockcontrol = f.add(camerarange, 'locked').name("Lock View").onChange(function(){camerarange.changeLock()});
	var resetControl = f.add(camerarange, 'reset').name('Reset');
	return f;

}

function construct2dInterfaceFolder(f, global, floorplanner)
{
	function onChangeSnapResolution()
	{
		BP3DJS.Configuration.setValue(BP3DJS.snapTolerance, BP3DJS.Dimensioning.cmFromMeasureRaw(view2dindirect.snapValue));
	}

	function onChangeGridResolution()
	{
		BP3DJS.Configuration.setValue(BP3DJS.gridSpacing, BP3DJS.Dimensioning.cmFromMeasureRaw(view2dindirect.gridResValue));
		blueprint3d.floorplanner.view.draw();
	}

	var units = BP3DJS.Configuration.getStringValue(BP3DJS.configDimUnit);
	var view2dindirect = {
		'snapValue': BP3DJS.Dimensioning.cmToMeasureRaw(BP3DJS.Configuration.getNumericValue(BP3DJS.snapTolerance)),
		'gridResValue': BP3DJS.Dimensioning.cmToMeasureRaw(BP3DJS.Configuration.getNumericValue(BP3DJS.gridSpacing))
	};

	f.removeFolder('2D Editor');

	var view2df = f.addFolder('2D Editor');
	view2df.add(BP3DJS.config, 'snapToGrid',).name("Snap To Grid");
	view2df.add(view2dindirect, 'snapValue', 0.1).name(`Snap Every(${units})`).onChange(onChangeSnapResolution);
	view2df.add(view2dindirect, 'gridResValue', 0.1).name(`Grid Resolution(${units})`).onChange(onChangeGridResolution);
	view2df.add(BP3DJS.config, 'scale', 0.25, 5, ).step(0.25).onChange(()=>{
//	view2df.add(BP3DJS.config, 'scale', 1.0, 10, ).step(0.25).onChange(()=>{
		blueprint3d.floorplanner.zoom();
//		blueprint3d.floorplanner.view.zoom();
		blueprint3d.floorplanner.view.draw();
	});


	var wallf = view2df.addFolder('Wall Measurements');
	wallf.add(BP3DJS.wallInformation, 'exterior').name('Exterior');
	wallf.add(BP3DJS.wallInformation, 'interior').name('Interior');
	wallf.add(BP3DJS.wallInformation, 'midline').name('Midline');
	wallf.add(BP3DJS.wallInformation, 'labels').name('Labels');
	wallf.add(BP3DJS.wallInformation, 'exteriorlabel').name('Label for Exterior');
	wallf.add(BP3DJS.wallInformation, 'interiorlabel').name('Label for Interior');
	wallf.add(BP3DJS.wallInformation, 'midlinelabel').name('Label for Midline');

	var carbonPropsFolder = getCarbonSheetPropertiesFolder(view2df, floorplanner.carbonSheet, global);

	view2df.open();
	return view2df;
}

function getGlobalPropertiesFolder(gui, global, floorplanner)
{
	var f = gui.addFolder('Interface & Configuration');

	var unitsf = f.addFolder('Units');
	var ficontrol = unitsf.add(global.units, 'a',).name("Feets'' Inches'").onChange(function(){global.setUnit("a")});
	var icontrol = unitsf.add(global.units, 'b',).name("Inches'").onChange(function(){global.setUnit("b")});
	var ccontrol = unitsf.add(global.units, 'c',).name('Cm').onChange(function(){global.setUnit("c")});
	var mmcontrol = unitsf.add(global.units, 'd',).name('mm').onChange(function(){global.setUnit("d")});
	var mcontrol = unitsf.add(global.units, 'e',).name('m').onChange(function(){global.setUnit("e")});
	global.setGUIControllers([ficontrol, icontrol, ccontrol, mmcontrol, mcontrol]);

//	BP3DJS.Dimensioning.cmFromMeasureRaw(scope.x);
//	BP3DJS.Dimensioning.cmToMeasureRaw(scope.x);

	f.open();
	return f;
}

function getCarbonSheetPropertiesFolder(gui, carbonsheet, globalproperties)
{
	var f = gui.addFolder('Carbon Sheet');
	var url = f.add(carbonsheet, 'url').name('Url');
	var width = f.add(carbonsheet, 'width').name('Real Width').max(1000.0).step(0.01);
	var height = f.add(carbonsheet, 'height').name('Real Height').max(1000.0).step(0.01);
	var proportion = f.add(carbonsheet, 'maintainProportion').name('Maintain Proportion');
	var x = f.add(carbonsheet, 'x').name('Move in X');
	var y = f.add(carbonsheet, 'y').name('Move in Y');

	var ax = f.add(carbonsheet, 'anchorX').name('Anchor X');
	var ay = f.add(carbonsheet, 'anchorY').name('Anchor Y');
	var transparency = f.add(carbonsheet, 'transparency').name('Transparency').min(0).max(1.0).step(0.05);
	carbonsheet.addEventListener(BP3DJS.EVENT_UPDATED, function(){
		url.updateDisplay();
		width.updateDisplay();
		height.updateDisplay();
		x.updateDisplay();
		y.updateDisplay();
		ax.updateDisplay();
		ay.updateDisplay();
		transparency.updateDisplay(width);
	});

	globalproperties.guiControllers.push(width);
	globalproperties.guiControllers.push(height);
	return f;
}

function getItemPropertiesFolder(gui, anItem)
{
	var f = gui.addFolder('Current Item (3D)');
	var inamecontrol = f.add(anItem, 'name');
	var wcontrol = f.add(anItem, 'width', 0.1, 1000.1).step(0.1);
	var hcontrol = f.add(anItem, 'height', 0.1, 1000.1).step(0.1);
	var dcontrol = f.add(anItem, 'depth', 0.1, 1000.1).step(0.1);
	var pcontrol = f.add(anItem, 'proportionalsize').name('Maintain Size Ratio');
	var lockcontrol = f.add(anItem, 'fixed').name('Locked in place');
	var deleteItemControl = f.add(anItem, 'deleteItem').name('Delete Item');

	function changed()
	{
		anItem.dimensionsChanged();
	}

	function lockChanged()
	{
		anItem.lockFlagChanged();
	}

	function proportionFlagChanged()
	{
		anItem.proportionFlagChange();
	}

	wcontrol.onChange(changed);
	hcontrol.onChange(changed);
	dcontrol.onChange(changed);
	pcontrol.onChange(proportionFlagChanged);
	lockcontrol.onChange(lockChanged);

	anItem.setGUIControllers([inamecontrol, wcontrol, hcontrol, dcontrol, pcontrol, lockcontrol, deleteItemControl]);

	return f;
}

function getWallAndFloorPropertiesFolder(gui, aWall)
{
	var f = gui.addFolder('Wall and Floor (3D)');
	var wcontrol = f.add(aWall, 'wallmaterialname', {Grey: 0, Yellow: 1, Checker: 2, Marble: 3, Bricks: 4}).name('Wall');
	var fcontrol = f.add(aWall, 'floormaterialname', {'Fine Wood': 5, 'Hard Wood': 6}).name('Floor');
	var multicontrol = f.add(aWall, 'forAllWalls').name('All Walls In Room');
	function wchanged()
	{
		aWall.wchanged();
	}

	function fchanged()
	{
		aWall.fchanged();
	}

	wcontrol.onChange(wchanged);
	fcontrol.onChange(fchanged);
	return f;
}

function datGUI(three, floorplanner)
{
	gui = new dat.GUI();
	aCameraRange = new CameraProperties();
	aCameraRange.three = three;
	aGlobal = new GlobalProperties();
	globalPropFolder = getGlobalPropertiesFolder(gui, aGlobal, floorplanner);

	f3d = globalPropFolder.addFolder('3D Editor')
	cameraPropFolder = getCameraRangePropertiesFolder(f3d, aCameraRange);

	var view2df = construct2dInterfaceFolder(globalPropFolder, aGlobal, floorplanner);
	view2df.open();

	selectionsFolder = gui.addFolder('Selections');
}


$(document).ready(function()
{
	dat.GUI.prototype.removeFolder = function(name)
	{
		var folder = this.__folders[name];
		if (!folder) {
			return;
		}
		folder.close();
		this.__ul.removeChild(folder.domElement.parentNode);
		delete this.__folders[name];
		this.onResize();
	}
	// main setup
	var opts =
		{
			floorplannerElement: 'floorplanner-canvas',
			threeElement: '#viewer',
			threeCanvasElement: 'three-canvas',
			textureDir: "models/textures/",
			widget: false
		}
	blueprint3d = new BP3DJS.BlueprintJS(opts);

	console.log(blueprint3d)
	console.log("fbezfbeziufze : : : : " + blueprint3d.floorplanner['view']['canvasElement'].height);
	blueprint3d.floorplanner['view']['canvasElement'].height = 100
	blueprint3d.floorplanner['view']['canvasElement'].width = 100

	var viewerFloorplanner = new ViewerFloorplanner(blueprint3d);

	blueprint3d.model.addEventListener(BP3DJS.EVENT_LOADED, function(){/* console.log('LOAD SERIALIZED JSON ::: '); */});

	mainControls(blueprint3d);
	blueprint3d.model.loadSerialized(myhome);


	addBlueprintListeners(blueprint3d);
	datGUI(blueprint3d.three, blueprint3d.floorplanner);
	blueprint3d.three.stopSpin();
//	gui.closed = true;


	$('#showAddItems').hide();
	$('#viewcontrols').hide();

	$('.card').flip({trigger:'manual', axis:'x'});
	$('#showFloorPlan').click(function()
	{
		$('.card').flip(false);
		$(this).addClass('active');
		$('#showDesign').removeClass('active');
		$('#showFirstPerson').removeClass('active');
		$('#showAddItems').hide();
		$('#viewcontrols').hide();
//		gui.closed = true;
		blueprint3d.three.pauseTheRendering(true);
		blueprint3d.three.getController().setSelectedObject(null);
	});

	$('#showDesign').click(function()
	{
		blueprint3d.model.floorplan.update();
		$('.card').flip(true);
//		gui.closed = false;
		$(this).addClass('active');
		$('#showFloorPlan').removeClass('active');
		$('#showFirstPerson').removeClass('active');

		$('#showAddItems').show();
		$('#viewcontrols').show();

		blueprint3d.three.pauseTheRendering(false);
		blueprint3d.three.switchFPSMode(false);
	});
	$('#showFirstPerson').click(function()
	{
		blueprint3d.model.floorplan.update();
		$('.card').flip(true);
//		gui.closed = true;
		$(this).addClass('active');
		$('#showFloorPlan').removeClass('active');
		$('#showDesign').removeClass('active');

		$('#showAddItems').hide();
		$('#viewcontrols').hide();

		blueprint3d.three.pauseTheRendering(false);
		blueprint3d.three.switchFPSMode(true);
	});

	$('#showSwitchCameraMode').click(function()
	{
		$(this).toggleClass('active');
		blueprint3d.three.switchOrthographicMode($(this).hasClass('active'));
	});

	$('#showSwitchWireframeMode').click(function()
	{
		$(this).toggleClass('wireframe-active');
		blueprint3d.three.switchWireframe($(this).hasClass('wireframe-active'));
	});

	$('#topview, #isometryview, #frontview, #leftview, #rightview').click(function(){
		blueprint3d.three.switchView($(this).attr('id'));
	});



	$("#add-items").find(".add-item").mousedown(function(e) {
		var modelUrl = $(this).attr("model-url");
		var itemType = parseInt($(this).attr("model-type"));
		var itemFormat = $(this).attr('model-format');
		var metadata = {
			itemName: $(this).attr("model-name"),
			resizable: true,
			modelUrl: modelUrl,
			itemType: itemType,
			format: itemFormat,

		}
		console.log('ITEM TYPE ::: ', itemType);
		if([2,3,7,9].indexOf(metadata.itemType) != -1 && aWall.currentWall)
		{
			var placeAt = aWall.currentWall.center.clone();
			blueprint3d.model.scene.addItem(itemType, modelUrl, metadata, null, null, null, false, {position: placeAt, edge: aWall.currentWall});
		}
		else if(aWall.currentFloor)
		{
			var placeAt = aWall.currentFloor.center.clone();
			blueprint3d.model.scene.addItem(itemType, modelUrl, metadata, null, null, null, false, {position: placeAt});
		}
		else
		{
			blueprint3d.model.scene.addItem(itemType, modelUrl, metadata);
		}
	});
});

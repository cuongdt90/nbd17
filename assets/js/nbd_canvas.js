var nbdCanvas = {
    /*properties*/
    stages : [],
    currentStageIndex : 0,
    
    /* init method */
    init: function(stages){
        this.stages = stages;
        var self = this;
        _.each(this.stages, function(stage, index){
            self.initStage( stage.elementId, index );
        });
    },    
    initStage: function( elementId, stageIndex ){
        var currentStage = this.stages[stageIndex],
            self = this,    
            _canvas = new fabric.Canvas(elementId);
        _canvas.setDimensions({'width' : currentStage.currentWidth, 'height' : currentStage.currentHeight});
        _canvas.controlsAboveOverlay = true;
        _canvas.calcOffset().renderAll();
        _canvas.on("mouse:down", function(options){
            self.mouseDownStage(options);
        });
        _canvas.on("mouse:over", function(options){
            self.mouseOverStage(options);
        });
        _canvas.on("mouse:out", function(options){
            self.mouseOutStage(options);
        });
        _canvas.on("mouse:move", function(options){
            self.mouseMoveStage(options);
        });        
        _canvas.on("mouse:up", function(options){
            self.mouseUpStage(options);
        });
        _canvas.on("path:created", function(options){
            self.pathCreated(options);
        });
        _canvas.on("object:added", function(options){
            self.objectAdded(options);
        });
        _canvas.on("object:selected", function(options){
            self.objectSelected(options);
        });
        _canvas.on("object:scaling", function(options){
            self.objectScaling(options);
        });
        _canvas.on("object:moving", function(options){
            self.objectMoving(options);
        });
        _canvas.on("object:rotating", function(options){
            self.objectRotating();
        });
        _canvas.on("object:modified", function(options){
            self.objectModified(options);
        });
        _canvas.on("before:render", function(options){
            self.beforeRender(options);
        });
        _canvas.on("after:render", function(options){
            self.afterRender(options);
        });
        _canvas.on("selection:cleared", function(options){
            self.selectionCleared();
        });
        _canvas.on("text:editing:entered", function(options){
            self.editingEntered(options);
        });     
        _canvas.on("text:selection:changed", function(options){
            self.selectionChanged(options);
        });           
        currentStage.canvas = _canvas;        
    },
    switchStageTo: function( index ){
        this.currentStageIndex = index;
    },
    mouseDownStage: function(options){
        
    },
    mouseUpStage: function(options){
        
    },    
    mouseOutStage: function(options){
        
    },
    mouseMoveStage: function(options){
        
    },  
    mouseOverStage: function(options){
        
    },
    pathCreated: function(options){
        
    },    
    objectAdded: function(options){
        
    },
    objectSelected: function(options){
        
    },  
    objectScaling: function(options){
        
    },
    objectMoving: function(options){
        
    },    
    objectRotating: function(options){
        
    },
    objectModified: function(options){
        
    },  
    beforeRender: function(options){
        
    },
    afterRender: function(options){
        
    },    
    selectionCleared: function(options){
        
    },
    editingEntered: function(options){
        
    },     
    selectionChanged: function(options){
        
    },      
};



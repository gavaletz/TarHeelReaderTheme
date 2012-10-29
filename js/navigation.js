// Code for navigation and settings menus
require(["jquery", "state", "controller", "hoverIntent"], function($, state, controller) {
    
    // list of settings
    var settings = ["voice", "pageColor", "textColor"], // the settings that we are concerned with (voice = speech)
        options = { // list of available options
                   speech: {
                        silent: 'silent',
                        child: 'child',
                        woman: 'female',
                        man: 'male'
                    },
                    colors: {
                        black: '000',
                        blue: '00f',
                        cyan: '0ff',
                        green: '0f0',
                        magenta: 'f0f',
                        red: 'f00',
                        white: 'fff',
                        yellow: 'ff0'
                    },
                    getKeyByValue: function(category, value) { // function to color option by value
                        var object = this[category];
                        for(var option in object) {
                           if(object.hasOwnProperty(option) ) {
                               if(object[option] === value)
                                    return option;
                             }
                        }
                    }
                  };
      
    $(function() {
        var $body = $("body"),
            selectorString = ".navigation > li, .mainSettings > li",
            currentSettings = getCurrentSettings();
        
        /*
         * Code to test hoverIntent
         *
         var config = {    
            over: function(e) { // on mouseover, show the submenus accordingly
             $(".submenu").hide(); // hide all menus and submenus
             $(this).find(".submenu").show();
            }, // end on mouseover  
            //timeout: 500, // number = milliseconds delay before onMouseOut    
            out: function() {
                $(".submenu, .innerSubmenu").hide();
            } // function = onMouseOut callback (REQUIRED)    
        };

        $(".navigation li").hoverIntent(config);
        */
       
        $body.on("click", selectorString, function(e) { // on mouseover, show the submenus accordingly
             $(".submenu").hide(); // hide all menus and submenus
             $(this).find(".submenu").show();
        }); // end on mouseover
    
        // if the user mouses over anywhere in the document except the submenu, close the submenu
        $(document).on("click", "head, body", function() {
            $(".submenu, .innerSubmenu").hide();
        }); // end on mouseover
        
    
        // prevent the submenu from closing if the mouseover is inside the submenu
        $body.on("click", selectorString, function(e) {
            if($(this).find(".submenu").is(":visible")) { // only hide the submenu if it was visible to begin with
              e.stopPropagation();
            }
        }); // end mouseover*/
        
        $body.on("click", ".mainSettings > li > .submenu > li", function() {
            $(".innerSubmenu").hide();
            $(this).find(".innerSubmenu").show();
        }); // end mouseover
        
        // if the click was made inside one of the menus, don't close the menu
        $body.on("click", ".navigation, .mainSettings", function(e) {
            if($(this).is(":visible")) {
                e.stopPropagation();
            }
        });
        
        // Show the nav panel on home icon click, and the settings panel on settings icon click
        $body.on('click', ".thr-home-icon img", function() {
            $(".navigation").toggle(0);
            $(".mainSettings").hide(); // hide settings
            return false; // for those who have JavaScript enabled, don't allow the click to go to the home page
        }); // end click
        
        $body.on("click", ".thr-settings-icon img", function() {
            updateCheckedOptions(); // update currently selected setting options marked with a check accordingly
            
            $(".mainSettings").toggle(0);
            $(".navigation").hide(); // hide navigation
            
            // hide the download options if we are not reading a book
            var $downloadMenu = $(".mainSettings #download");
            console.log($(".thr-book-page"));
            $(".thr-book-page").length ? $downloadMenu.show() : $downloadMenu.hide();
            
            return false; // for those who have JavaScript enabled, don't allow the click to go to the settings page
        }); // end click
        
        // the user is changing a setting, adjust settings and update accordingly
        $body.on("click", ".mainSettings .submenu li > a", function() {
            // deal with the anchor's parent <li>
            var $this = $(this),
                thisText = $this.text().toLowerCase(),
                $parent = $this.parent(),
                parentText = $parent.length ? $parent.text().toLowerCase() : 0;
                
            if(thisText != "page colors" && thisText != "text colors") {
               changeSetting($parent, parentText);
               return false;
            }
            
        });
        
        // if the user clicks anywhere other than one of the menus, hide the menus
        $(document).on("click", "head, body", function() {
            $(".navigation, .mainSettings").hide();
        }); // end click
      
      }); // end ready
      
      function getCurrentSettings() {
         return {
             speech: state.get(settings[0]),
             pageColor: state.get(settings[1]),
             textColor: state.get(settings[2])
         }
      }
      
      function changeSetting($element, text) {
          var parentID = $element.parent().attr("id").toLowerCase().replace("#", ""),
              value;

          // which option are we dealing with?
          if(parentID == "speechoptions") {
              value = getOptionValue("speech", text);
              state.set("voice", value);
              
          } else if(parentID == "pagecolorsoptions") {
              value = getOptionValue("colors", text);
              state.set("pageColor", value);
              
          } else if(parentID == "textcolorsoptions") {
              value = getOptionValue("colors", text);
              state.set("textColor", value);
          } else {// not a valid option, return
              return; 
          }
          
          controller.stateChange(); // update the page
          updateCheckedOptions(); // update the check marks next to the currently selected options
      }
      
      function getOptionValue(category, selectedOption) {
          for(option in options[category]) {
              if(option == selectedOption) {
                  return options[category][option];
              }
          }
          return null;
      }
     
      function updateCheckedOptions() {
          $(".checked").removeClass("checked");
          var currentSettings = getCurrentSettings();
          console.log(currentSettings.speech);
          // update the currently set options with a check mark next to them
          $("#speechOptions " + "#" + currentSettings.speech).addClass("checked");
          $("#pageColorsOptions " + "." + options.getKeyByValue("colors", currentSettings.pageColor)).addClass("checked");
          $("#textColorsOptions " + "." + options.getKeyByValue("colors", currentSettings.textColor)).addClass("checked");
      }
      
}); // end require
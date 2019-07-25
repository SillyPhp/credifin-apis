function removeIt(thisObj) {
    thisObj.parent().next().remove();
    thisObj.parent().remove();
}

(function ( $, window, document, undefined ) {
    "use strict";

    // Create the defaults once
    var pluginName = "businessHoursWidget",
        defaults = {
            container : ".results",
            addButton: ".btn.add",
            cancelButton: ".btn.cancel",
            // The DOM structure must stay the same
            // span + strong + strong + .cancelCurrent
            resultTemplate: '<p><span></span> : from <strong></strong> to <strong></strong> <i class="fa fa-times cancelCurrent" onclick="removeIt($(this));"></i></p>',
            timeInputs : ".selection input[type='time']",
            checkAllDays: '#toallday',
            debug : true
        };

    // The actual plugin constructor
    function Plugin ( elements, options ) {
        this.inputs = elements;

        this.settings = $.extend( {}, defaults, options );
        this.log=function(l){if(typeof console != 'undefined' && this.settings.debug){console.log(l);}};
        this._defaults = defaults;
        this._name = pluginName;

        this.$resultTemplate = $(this.settings.resultTemplate);

        this.$inputsChecked = null;
        this.$inputsRange = null;

        this.$results = null;

        this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend(Plugin.prototype, {
        init: function () {
            var plugin = this;

            $(plugin.settings.addButton).on("click", function(){
                // Business hours lines init
                plugin.$results = [];

                var errors = plugin.startParsing();
                if(errors) {
                    alert(errors);
                    return false;
                }
                plugin.appendResults();

                for(var k=0;k<plugin.$results.length;k++)
                    plugin.log(plugin.$results[k].html());

                $(plugin.inputs).each(function () {
                    this.checked = false;
                });



                return false;
            });

            $(plugin.settings.cancelButton).on("click", function(){
                $(plugin.settings.container+" p").remove();
                plugin.log('removing all lines');
                return false;
            });

            $(plugin.settings.container+" i").on("click", function(){
                $(this).parent().remove();
                plugin.log('removing a line');
                return false;
            });

            $(plugin.settings.checkAllDays).on("change", function(){
                $(plugin.inputs).each(function () {
                    this.checked = $(plugin.settings.checkAllDays)[0].checked;
                });
            });
        },
        appendResults : function () {
            for(var i in this.$results) {
                this.$results[i].appendTo(this.settings.container);
                $('<input type="hidden" name"business_hours[]" value="'+(this.$results[i].text())+'" />').appendTo(this.settings.container);
            }
        },
        removeInputsFromRanges : function ($inputsToRemoveFromRange) {
            $.each($inputsToRemoveFromRange,function (i,$input) {
                $input[0].checked = false;
            });
        },
        startParsing: function () {
            // This set contains only checked elements
            this.$inputsChecked = $(this.inputs).filter(':checked');

            // Index of the first checked element in the inputs list
            var startIndex = $(this.inputs).index(this.$inputsChecked.eq('0'))-1;
            this.log('start index : '+startIndex);

            // We need a range containing all inputs starting from startIndex so we can compare inputs lists
            // Filter only if startIndex is not -1 ( otherwise gt() doesn't work)
            this.$inputsRange = $(this.inputs);
            if(startIndex != -1)
                this.$inputsRange = this.$inputsRange.filter( ':gt('+startIndex+')');

            this.log('Input Range total size : ' + this.$inputsRange.length);

            var last = this.$results.length;
            // We start from the first checked input. Then we'll look for the nexts
            var $currentDay = this.$inputsChecked.eq(0);
            var $inputsToRemoveFromRange = [];

            if($currentDay.length) {
                // New Business Hours line initialization
                this.$results[last] = this.$resultTemplate.clone();

                this.log('New line');

                var from = $currentDay.val();
                // We'll need to reduce the input range so we can recursively call the function without index
                $inputsToRemoveFromRange.push($currentDay);
                this.log('From : '+from);

                var to = '';
                var j = 1;
                // Search through all the next checked input and stop at first non-checked input
                // If we stop its either a gap between selected days, or there's no more checked inputs
                while(this.$inputsRange[j] && this.$inputsRange[j].checked) {
                    to  = this.$inputsRange.eq(j).val();
                    $inputsToRemoveFromRange.push(this.$inputsRange.eq(j));

                    this.log('current input index : '+j);
                    this.log('Next checked input found :'+to);
                    j++;
                }

                this.log('To : '+to);
                if(to)
                    to = ' - '+to;

                // Now we can fill the line and insert it in the DOM
                this.$results[last].find('span').text(from + to);
                for(var i=0;i<2;i++) {
                    var v = $(this.settings.timeInputs).eq(i).val();
                    // Returning something is considered error and will be displayed
                    if(!v)
                        return 'You must enter a well formatted time';
                    this.$results[last].find('strong:eq('+i+')').text(v);
                }


                // Remove all parsed inputs from range
                this.removeInputsFromRanges($inputsToRemoveFromRange);
                this.log('Remaining checked inputs to parse : '+this.$inputsChecked.length);

                // After parsed inputs removal, we start again if there's still checked inputs to parse.
                if($(this.inputs).filter(':checked').length)
                    return this.startParsing();

                // Empty string returned means no error
                return '';
            }
            else {
                return 'Please select your business hours';
            }
        }
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[ pluginName ] = function ( options ) {
        if ( !$.data( this, "plugin_" + pluginName ) ) {
            return $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
        }
        else {
            return $.data( this, "plugin_" + pluginName);
        }
    };

})( jQuery, window, document );
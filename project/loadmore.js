(function ($) {
    $.fn.loaddata = function (options) { // Settings
        var settings = $.extend({
            loading_gif_url: "ajax-loader.gif", //url to loading gif
            end_record_text: 'No more posts found!', //end of record text
            loadbutton_text: 'Load More posts!', //load button text
            data_url: 'loadmorePosts.php', //url to PHP page
            start_page: 1 //initial page
        }, options);

        var el = this;
        loading = false;
        end_record = false;

        //initialize load button
        var load_more_btn = $('<button/>').text(settings.loadbutton_text).addClass('load-button').click(function (e) {
            contents(el, this, settings); //load data on click
        });

        contents(el, load_more_btn, settings); //initial data load	
    };

    //Ajax load function
    function contents(el, load_btn, settings) {
        var load_img = $('<img/>').attr('src', settings.loading_gif_url).addClass('loading-image'); //loading image
        var record_end_txt = $('<div/>').text(settings.end_record_text).addClass('end-record-info'); //end record text

        if (loading == false && end_record == false) {
            loading = true; //set loading flag on
            el.append(load_img); //append loading image

            //temporarily remove button on click
            if (load_btn.type === 'submit' || load_btn.type === 'click') {
                load_btn.remove(); //remove loading img
            }

            $.post(settings.data_url, {
                'page': settings.start_page
            }, function (data) { //jQuery Ajax post
                if (data.trim().length == 0) { //if no more records
                    el.append(record_end_txt); //show end record text
                    load_img.remove(); //remove loading img
                    load_btn.remove(); //remove load button
                    end_record = true; //set end record flag on
                    return; //exit
                }
                loading = false; //set loading flag off
                load_img.remove(); //remove loading img 
                el.append(data).append(load_btn); //append content and button
                settings.start_page++; //page increment
            })
        }
    }

})(jQuery);

$("#results").loaddata();
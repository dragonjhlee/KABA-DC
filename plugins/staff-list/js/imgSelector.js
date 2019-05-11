jQuery(document).ready(function($){

    var imgSelector1;
    var imgSelector2;

    $(abcfslIS.btnImg + 'L').click(function(e) {

        e.preventDefault();
        //console.log(abcfslIS.btnImg + 'L');

        if (imgSelector1) {
            imgSelector1.open();
            return;
        }

        //Extend the wp.media object
        imgSelector1 = wp.media.frames.file_frame = wp.media({
            //title: abcfslIS.title,
            button: { text:  abcfslIS.button },
            library: { type: 'image' },
            frame:    'select',
            state:   'mystate'
        });

        imgSelector1.states.add([
          new wp.media.controller.Library({
            id: 'mystate',
            title: abcfslIS.title,
            priority: 20,
            toolbar: 'select',
            filterable: 'uploaded',
            library: wp.media.query( imgSelector1.options.library ),
            multiple: false,
            editable: false,
            displayUserSettings: false,
            displaySettings: true,
            allowLocalEdits: true
          })
        ]);

        //When a file is selected, grab the URL and set it as the text field's value
        imgSelector1.on('select', function() {
            var attachment = imgSelector1.state().get('selection').first().toJSON();

            //console.log(attachment.id);
            $(abcfslIS.imgUrl + 'L').val(attachment.sizes[$('select[name="size"]').val()].url);
            $(abcfslIS.imgID + 'L').val(attachment.id);
        });

        //Open the uploader dialog
        imgSelector1.open();
    });

    $(abcfslIS.btnImg + 'S').click(function(e) {

        e.preventDefault();

        if (imgSelector2) {
            imgSelector2.open();
            return;
        }

        imgSelector2 = wp.media.frames.file_frame = wp.media({
            button: { text:  abcfslIS.button },
            library: { type: 'image' },
            frame:    'select',
            state:   'mystate'
        });

        imgSelector2.states.add([
          new wp.media.controller.Library({
            id: 'mystate',
            title: abcfslIS.title,
            priority: 20,
            toolbar: 'select',
            filterable: 'uploaded',
            library: wp.media.query( imgSelector2.options.library ),
            multiple: false,
            editable: false,
            displayUserSettings: false,
            displaySettings: true,
            allowLocalEdits: true
          })
        ]);

        imgSelector2.on('select', function() {
            var attachment = imgSelector2.state().get('selection').first().toJSON();

            $(abcfslIS.imgUrl + 'S').val(attachment.sizes[$('select[name="size"]').val()].url);
            $(abcfslIS.imgID + 'S').val(attachment.id);
        });

        imgSelector2.open();
    });
});
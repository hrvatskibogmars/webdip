var ButtonUpload = (function()
{
    var options =
    {
        input: Object,
        button: Object,
        photoPlaceholder: Object,
        photoOptions:
        {
            class: String,
            style: String,
            id: String
        },
        onChange: Object,
        afterClick: Object
    };
    var UploadButton = function(opt)
    {
        options = opt;

        options.input.style.display = "none";


        options.button.onclick = function()
        {
            console.log(options.button);

            $(options.input).click();
            options.afterClick(options.input, options.button);
            return false;
        };

        options.file_selected = function(evt)
        {
            console.log("file changed");

            var files = evt.target.files;

            var result = '';
            var file;
            for (var i = 0; file = files[i]; i++)
            {
                if (!file.type.match('image.*'))
                    continue;

                reader = new FileReader();
                reader.onload = (function (tFile)
                {
                    return function (evt)
                    {
                        var div = document.createElement('div');
                        div.innerHTML = '<img class="' + options.photoOptions.class + '" style="' + options.photoOptions.style + '" src="' + evt.target.result + '" id="' + options.photoOptions.id + '" />';
                        $(options.photoPlaceholder).html(div);
                        if (options.onChange)
                            options.onChange(evt);
                    };
                }(file));
                reader.readAsDataURL(file);
            }

        };
        options.input.addEventListener("change", options.file_selected, false);

    }

    return UploadButton;
}());

var FormUpload = (function() {

    var options =
    {
        url: "",
        data: Object,
        beforeSendHandler: Object,
        completeHandler: Object,
        errorHandler: Object,
        progressHandler: Object
    };

    function AjaxUpload(opt)
    {
        var _this = this;
        options = opt;

    }

    AjaxUpload.prototype.upload = function()
    {
        var ajax_config =
        {
            url: options.url,
            type: 'POST',
            dataType: "json",
            xhr: function()
            {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", options.progressHandler, false);
                return xhr;
            },
            //Ajax events
            beforeSend: options.beforeSendHandler,
            success: options.completeHandler,
            error: options.errorHandler,
            // Form data
            data: options.data,
            // tell JQuery not to process data or content-type
            cache: false,
            contentType: false,
            processData: false
        };

        $.ajax(ajax_config);
    }

    return AjaxUpload;
}());

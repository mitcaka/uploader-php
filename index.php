<html>
<head>
    <link href="https://rawgithub.com/hayageek/jquery-upload-file/master/css/uploadfile.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://rawgithub.com/hayageek/jquery-upload-file/master/js/jquery.uploadfile.min.js"></script>
</head>
<body>
<div id="deleteupload">Upload</div>
<script>
    $("#deleteupload").uploadFile({
        url: "http://localhost/uploader/php/upload.php",
        dragDrop: true,
        multiple:true,
        acceptFiles:"image/*",
        allowedTypes:"jpg,png,gif,jpge",
        showPreview:true,
        previewHeight: "100px",
        previewWidth: "100px",
        maxFileSize:20000*1024,
        maxFileCount:3,
        fileName: "myfile",
        returnType: "json",
        showDelete: true,
        showDownload:true,
        statusBarWidth:600,
        dragdropWidth:600,
        onSuccess:function(files,data,xhr,pd)
        {
            location.reload();

        },
        onLoad:function(obj)
        {
            $.ajax({
                cache: false,
                url: "http://localhost/uploader/php/load.php",
                dataType: "json",
                success: function(data)
                {
                    for(var i=0;i<data.length;i++)
                    {
                        obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                    }
                }
            });
        },
        deleteCallback: function (data, pd) {
            for (var i = 0; i < data.length; i++) {
                $.post("http://localhost/uploader/php/delete.php", {op: "delete",name: data[i]},
                    function (resp,textStatus, jqXHR) {
                        //Show Message
                        alert("File Deleted");
                    });
            }
            pd.statusbar.hide(); //You choice.

        },
        downloadCallback:function(filename,pd)
        {
            location.href="http://localhost/uploader/php/download.php?filename="+filename;
        }
    });
</script>
</body>
</html>


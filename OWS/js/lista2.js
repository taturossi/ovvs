(function () {
    $('#btnRightSW').click(function (e) {
        var selectedOpts = $('#lstBoxSWD option:selected');
        if (selectedOpts.length == 0) {
            alert("Ningun switch seleccionado.");
            e.preventDefault();
        }

        $('#lstBoxSWA').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllRightSW').click(function (e) {
        var selectedOpts = $('#lstBoxSWD option');
        if (selectedOpts.length == 0) {
            alert("Ningun switch seleccionado.");
            e.preventDefault();
        }

        $('#lstBoxSWA').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeftSW').click(function (e) {
        var selectedOpts = $('#lstBoxSWA option:selected');
        if (selectedOpts.length == 0) {
            alert("Ningun switch seleccionado.");
            e.preventDefault();
        }

        $('#lstBoxSWD').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllLeftSW').click(function (e) {
        var selectedOpts = $('#lstBoxSWA option');
        if (selectedOpts.length == 0) {
            e.preventDefault();
            alert("Ningun switch seleccionado.");
        }

        $('#lstBoxSWD').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
}(jQuery));
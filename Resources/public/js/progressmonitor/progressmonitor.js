progressWork = function (uid, progressbar, elementotesto) {
    $.ajax({
        url: Routing.generate('bfa_progress', { uid: uid }),
        type: 'POST',
        dataType: 'json',
        data: null,
        success: function (res) {
            progressbar.attr('aria-valuenow', res.progress);
            progressbar.attr('aria-valuemax', res.max);
            progressbar.css('width', 100 * res.progress / res.max + "%");
            var v = 100 * res.progress / res.max;
            progressbar.html(v + "%");
            if (res.data) {
                if (res.data.html) {
                    elementotesto.html(res.data.html);
                }
                if (res.data.append) {
                    elementotesto.html(elementotesto.html() + res.data.append);
                }
            }


            if (res.progress < res.max) {
                setTimeout(progressWork(uid, progressbar, elementotesto), 8000);
            } else {
                $.ajax({
                    url: Routing.generate('bfa_progress_quit', { uid: uid }),
                    type: 'POST',
                    dataType: 'json',
                    data: null,
                    timeout: 600000,
                    error: null,
                    success: function (res) {

                    }
                });
            }
        }
    });

};



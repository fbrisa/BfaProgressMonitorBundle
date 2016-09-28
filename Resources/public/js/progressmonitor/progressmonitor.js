progressWork = function (uid, progressbar, elementotesto,callback) {
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
            
            var d_html=null;
            var d_append=null;
            var d_data=null;
            
            
            if (res.data) {
                if (res.data.append) {
                    d_append=res.data.append;
                    elementotesto.html(elementotesto.html() + d_append);
                }

                if (res.data.html) {
                    d_html=res.data.html;
                    elementotesto.html(d_html);
                }                
                
                if (res.data.data) {
                    d_data=res.data.data;
                }
            }

            if (callback) {
                callback(d_data,d_html,d_append);
            }

            if (res.progress < res.max) {
                setTimeout(function() {progressWork(uid, progressbar, elementotesto,callback);}, 1000);
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



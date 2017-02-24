var apiURL = "/symfony3/web/app_dev.php/api/";
var nbarticleCall = 3;
var offsetArticle = 3;
var nbCall = 1;
var tempsEntreCall = 500;
var currentTime = 0;
var endArticles = false;

$(window).ready(function () {
    $(window).on("scroll", function () {
        /*
         console.log("scrolltop : " + $(window).scrollTop());
         console.log($(window).scrollTop() + window.screen.height);
         console.log("taille fenetre: " + window.screen.height);
         console.log("taile doc: " + $(document).height());
         */

        //var tailleDoc =  $(document).height() -100;
        var tailleDoc = $(document).height();
        var tailleScroll = $(window).scrollTop() + window.screen.height;

        if (tailleScroll > tailleDoc) {
            if ($.now() > currentTime + tempsEntreCall && !endArticles) {
                console.log("Time: " + currentTime)
                callApi("posts/offset/" + offsetArticle * nbCall + "/" + nbarticleCall, "GET", [], function (data) {
                    if (!data.length == 0) {
                        data.forEach(function (post) {
                            //console.log(post);
                            $(setArticle(post))
                                    .insertAfter($(".col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1").last());
                        });
                    } else {
                        endArticles = true;
                        $('<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 text-center">Il n\'y a plus d\'article a chargé</div>')
                                .insertAfter($(".col-lg-8.col-lg-offset-2.col-md-10.col-md-offset-1").last());
                    }

                });

                currentTime = $.now();
                nbCall++;
            }
        }

    });
});

function callApi(ressource, type = "GET", param = [], callback) {
    $.ajax({
        url: apiURL + ressource,
        type: type,
        data: param,
        dataType: 'json',
        success: function (data, statut) {
            //console.log(data);
            callback(data.data);
        },
        error: function (resultat, statut, erreur) {

        }
    });
}

function setArticle(article) {
    return '<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" data-article-id="' + article.id + '">' +
            '<article class="post-preview">' +
            '<a href="posts/' + article.id + '/show">' +
            '<h2 class="post-title">' +
            article.title +
            '</h2>' +
            '<h3 class="post-subtitle">' +
            article.summary +
            '</h3>' +
            '</a>' +
            '<p class="post-meta">' +
            'Posté par <a href="">' + article.author + '</a> le ' + article.created_at.date +
            '</p>' +
            '</article>' +
            '</div>';
}
//Hello missipi
var movie_category = document.getElementById('category_to_display').value
console.log(movie_category)

$(document).ready(function() {
    let endpoint = 'https://api.themoviedb.org/3/discover/movie?api_key=22f118d1998ea34386d70fba4d592724&with_genres='

    $.ajax({
        url: endpoint + movie_category,
        contentType: "application/json",
        dataType: 'json',
        success: function(result) {
            put_teh_movies_out_there(result)
        }
    });
});




function put_teh_movies_out_there(result) {
    console.log("putting movies in")
    console.log(result)
    console.log(result.results)
    les_resultats = result.results;

    for (let index = 0; index < les_resultats.length; index++) {
        var node = document.createElement("div");
        var textnode = document.createTextNode(les_resultats[index].overview);
        var actual = document.createElement("div");
        var le_img = document.createElement("img");

        node.className = "our_li_container_comrade";

        actual.className = "le_actual_li_content"

        le_url = 'displaymovie.php?movie_to_show=' + les_resultats[index].id;

        img_href_container = document.createElement("a")
        img_href_container.className = "limagecontainer";
        img_href_container.setAttribute("href", le_url)

        // img_href_container.setAttribute('href', 'https://api.themoviedb.org/3/movie/' + les_resultats[index].id + '?api_key=22f118d1998ea34386d70fba4d592724&language=en-US');

        le_img.src = 'https://image.tmdb.org/t/p/w500' + les_resultats[index].poster_path;
        le_img.className = "le_poster_image";

        actual.appendChild(textnode);

        img_href_container.appendChild(le_img);
        node.appendChild(actual);
        node.appendChild(img_href_container)
        document.getElementsByClassName("movies_categories_moz")[0].appendChild(node);

    }
}
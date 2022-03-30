// hELLO WORLD



$(document).ready(function() {
    let endpoint = 'https://api.themoviedb.org/3/genre/movie/list?api_key=API_KEY_HERE&language=en-US'

    $.ajax({
        url: endpoint + $(this).text(),
        contentType: "application/json",
        dataType: 'json',
        success: function(result) {
            log_le_output(result)
            display_the_categories(result)
        }
    });
});

function log_le_output(result) {
    console.log("Result below")
    console.log(result)
    console.log("Result length")
    console.log(result.genres.length)

}

function display_the_categories(results) {
    for (let i = 0; i < results.genres.length; i++) {
        genre_to_output = results.genres[i]
        console.log(genre_to_output)

        var la_boite = document.createElement("a");
        var le_image_hon_hon = document.createElement("img");
        var le_text = document.createElement("div");

        le_text.innerHTML = genre_to_output.name;

        le_genre = 'with_genres=' + genre_to_output.id
        le_url = 'selected_category.php?' + le_genre;


        la_boite.className = "la_boite_contenante";
        la_boite.setAttribute('href', le_url);

        la_boite.appendChild(le_text);
        la_boite.appendChild(le_image_hon_hon);
        document.getElementsByClassName("movies_categories_moz")[0].appendChild(la_boite);



    }

}
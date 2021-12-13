var movie_category = document.getElementById('movie_to_display').value
console.log(movie_category)

$(document).ready(function() {
    let endpoint = 'https://api.themoviedb.org/3/movie/' + movie_category + '?api_key=22f118d1998ea34386d70fba4d592724&language=en-US'
    $.ajax({
        url: endpoint,
        contentType: "application/json",
        dataType: 'json',
        success: function(result) {
            display_the_movie_info(result)
        }
    });
});

function display_the_movie_info(result) {
    console.log("test")
    console.log(result)
    div_to_target = document.getElementsByClassName('movie_info')[0]

    le_movie_title = document.createElement("div");
    le_movie_title.innerHTML = result.title

    div_to_target.appendChild(le_movie_title);
    div_to_target.innerHTML = le_movie_title

}
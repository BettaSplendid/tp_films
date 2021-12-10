// Here be monsters.
//  ,---.
// ( @ @ )
//  ).-.(
// '/|||\`
//   '|`     


var sessions_data = get_session_values()
console.log(sessions_data)

function get_session_values() {
    // var le_session_values_array = [
    //     document.getElementById('pass_session_mail').value,
    //     document.getElementById('pass_session_pseudo').value,
    //     document.getElementById('pass_session_logged').value,
    //     document.getElementById('pass_session_id').value,
    //     document.getElementById('pass_session_age').value,
    //     document.getElementById('pass_session_adult').value
    // ];

    var le_session_values_array2 = {
        lapin: document.getElementById('pass_session_mail').value,
        lapin1: document.getElementById('pass_session_pseudo').value,
        lapin2: document.getElementById('pass_session_logged').value,
        lapin3: document.getElementById('pass_session_id').value,
        lapin4: document.getElementById('pass_session_age').value,
        lapin5: document.getElementById('pass_session_adult').value
    };
    return le_session_values_array2
        // console.log(le_session_values_array)
        // console.log(le_session_values_array2)
}

var le_output

$(document).ready(function() {
    let endpoint = 'https://api.themoviedb.org/3/movie/top_rated?api_key=22f118d1998ea34386d70fba4d592724&language=en-US'
    let apiKey = '22f118d1998ea34386d70fba4d592724'

    $.ajax({
        url: endpoint + "?key=" + apiKey + " &q=" + $(this).text(),
        contentType: "application/json",
        dataType: 'json',
        success: function(result) {
            log_le_output(result)
        }
    });
});

function log_le_output(result) {
    console.log("agaga")
        // console.log(result)
    put_teh_movies_out_there(result)
}

function put_teh_movies_out_there(result) {
    console.log("putting movies in")
        // document.getElementsByClassName("the_cool_movies")[0].innerHTML = result.results[0].id

    // target = document.getElementsByClassName("the_cool_movies")[0]
    les_resultats = result.results;

    console.log(les_resultats)
    console.log(les_resultats.length)

    for (let index = 0; index < les_resultats.length; index++) {
        var node = document.createElement("li");
        var textnode = document.createTextNode(les_resultats[index].overview);
        var actual = document.createElement("div");
        var le_img = document.createElement("img");

        node.className = "our_li_container_comrade";

        actual.className = "le_actual_li_content"

        le_img.src = 'https://image.tmdb.org/t/p/original/wwemzKWzjKYJFfCeiB57q3r4Bcm.png'
        le_img.className = "le_poster_image";

        actual.appendChild(textnode);
        node.appendChild(actual);
        node.appendChild(le_img);
        document.getElementById("the_cool_movies_ul").appendChild(node);

    }
}









// function ShowFilm(Films) {

//     let Result = Films.results;
//     // console.log(FilmId);

//     $("#films_populaires").append("<ul></ul>");

//     Result.forEach((objet) => {

//                 if (FilmId === objet.id) {

//                     $("#films_populaires").find("h1").append(
//                         $ { objet.title } < br >
//                     );

//                     $("#films_populaires").find("h1").append(
//                         titre original: $ { objet.original_title } < br >
//                     );

//                     $("#films_populaires").find("ul").append( <
//                         li class = "article-title" > Langue en VO: $ { objet.original_language } < /li>
//                     );

//                     $("#films_populaires").find("ul").append( <
//                         li class = "article-title" > Note: $ { objet.vote_average }
//                         / 10 </li >
//                     );

//                     $("#films_populaires").find("p").append(
//                         $ { objet.overview }
//                     );

//                     $("#films_categories").append( <
//                         img src = "http://image.tmdb.org/t/p/w300/${objet.poster_path}"
//                         alt = "poster" >
//                     );

//                     // console.log(liste_Genres);
//                     // console.log(objet.genre_ids);

//                     objet.genre_ids.forEach((id) => {
//                         // console.log("valeur id film :" + id);

//                         liste_Genres.forEach((ID) => {
//                             // console.log("valeur id de liste des genres : " + ID.id);

//                             if (id === ID.id) {
//                                 //console.log(ID.name);
//                                 $("#cat").find("p").append($ { ID.name });
//                             }

//                         })

//                     })

//                 }

// async function fetchMovies() {
//     return await fetch('https://api.themoviedb.org/3/movie/top_rated?api_key=22f118d1998ea34386d70fba4d592724&language=en-US');
// }

// var p = fetchMovies()
// p.then(function(response) {
//     return response;
// })

// // p.then(ze_movies => (console.log(response)))
// wait
// console.log(p)
// console.log(p.value)
// document.getElementsByClassName("the_cool_movies")[0].innerHTML = 0
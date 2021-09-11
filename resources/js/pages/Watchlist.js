import { useEffect, useState } from "react";
import { Col, Row } from "react-bootstrap"
import Show from "../components/Show";

const Watchlist = ({watchlist, setWatchlist, cookies, setCookie}) => {
    const [watchlistShows, setWatchlistShows] = useState([])
    useEffect(() => {
        const getWatchlistShows = async () => {
            const raw = await fetchWatchlistShows();
            const shows = raw.map((show) => {
              var image = '/no-img.jpg';
              var nextepisode = null;
              var rating = '';
              var imdbUrl = 'https://imdb.com/title/';
              var isWatching = false;
      
              try {
                isWatching = watchlist.includes(show.id);
                image = show.image.medium
                rating = show.rating.average ? show.rating.average+'/10' : null;
                imdbUrl = show.externals.imdb ? imdbUrl+show.externals.imdb : null;
                nextepisode = {
                    airdate: show._embedded.nextepisode.airstamp != null ? show._embedded.nextepisode.airstamp : null,
                    episode: show._embedded.nextepisode.season != null ? 's'+show._embedded.nextepisode.season+'e'+show._embedded.nextepisode.number : null,
                    url: show._embedded.nextepisode.url != null ? show._embedded.nextepisode.url : null
                  };
              } catch (error) {
                
              }
              return {
                id: show.id,
                imdburl: imdbUrl,
                name: show.name,
                status: show.status,
                rating: rating,
                image: image,
                nextepisode: nextepisode,
                isWatching: isWatching
            }});
            setWatchlistShows(shows);
        }
        const fetchWatchlistShows = async () => {
            var shows = [];
            for(const id of watchlist){
                const apiUrl = 'https://api.tvmaze.com/shows/'+id+'?embed=nextepisode';
                const result = await fetch(apiUrl);
                const data = await result.json();
                shows.push(data);
            }
            return shows;
        }
      
        getWatchlistShows();
    }, [watchlist]);

    return (
        <div>
            <h1 className="text-white">Mano serialai</h1>
            <Row className="py-3">
            {
                watchlistShows.map((show) => (
                    <Col key={show.id} sm="6" md="4" lg="3">
                        <Show watchlist={watchlist} setWatchlist={setWatchlist} cookies={cookies} setCookie={setCookie} key={show.id} show={show}></Show>
                    </Col>
                ))
                }
            </Row>
        </div>
    )
}

export default Watchlist

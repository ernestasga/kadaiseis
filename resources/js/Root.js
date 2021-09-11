import { useState, useEffect } from 'react';
import { Container } from 'react-bootstrap';
import { BrowserRouter, Route } from "react-router-dom";
import './App.css';
import Header from './components/Header';
import Search from './components/Search';
import PopularShows from './components/PopularShows';
import About from './pages/About';
import Watchlist from './pages/Watchlist';
import { useCookies } from 'react-cookie';
import Footer from './components/Footer';

function Root() {
  const [popularShows, setPopularShows] = useState([]);
  const [searchResults, setSearchResults] = useState();
  const [cookies, setCookie] = useCookies(['watchlist']);
  const initialWatchlist = cookies.watchlist != null ? cookies.watchlist : [];
  const [watchlist, setWatchlist] = useState(initialWatchlist);
  const [socialLinks, setSocialLinks] = useState([])
  useEffect(() => {
    const getPopularShows = async () => {
      const raw = await fetchPopularShows();
      const shows = raw.map((show) => {
        var image = '/no-img.jpg';
        var nextepisode = null;
        var rating = '';
        var imdbUrl = 'https://imdb.com/title/';
        var isWatching = false;
        try {
          isWatching = watchlist.includes(show.id);
          image = show.image.medium;
          rating = show.rating.average ? show.rating.average+'/10' : null;
          imdbUrl = show.externals.imdb ? imdbUrl+show.externals.imdb : null;
          nextepisode = {
            airdate: show._embedded.nextepisode.airstamp != null ? show._embedded.nextepisode.airstamp : null,
            episode: show._embedded.nextepisode.season != null ? 's'+show._embedded.nextepisode.season+'e'+show._embedded.nextepisode.number : null,
            url: show._embedded.nextepisode.url != null ? show._embedded.nextepisode.url : null
          };
        } catch (error) {
          //console.log(error)
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
      setPopularShows(shows);
      getSocialLinks();
    }

    getPopularShows();
  }, [watchlist]);
  const getSocialLinks = async () => {
    const raw = await fetchSocialLinks();
    setSocialLinks(raw);
    
  };
  const getSearchResult = async (input) => {
    if (input.length > 3) {
      const raw = await fetchSearchResults(input);
      var image = '/no-img.jpg';
      var nextepisode = null;
      var rating = '';
      var imdbUrl = 'https://imdb.com/title/';
      var isWatching = false;

      try {
        isWatching = watchlist.includes(raw.id);
        image = raw.image.medium;
        rating = raw.rating.average ? raw.rating.average+'/10' : '';
        imdbUrl = raw.externals.imdb ? imdbUrl+raw.externals.imdb : null;
        nextepisode = {
          airdate: raw._embedded.nextepisode.airstamp != null ? raw._embedded.nextepisode.airstamp : null,
          episode: raw._embedded.nextepisode.season != null ? 's'+raw._embedded.nextepisode.season+'e'+raw._embedded.nextepisode.number : null,
          url: raw._embedded.nextepisode.url != null ? raw._embedded.nextepisode.url : null
        };
      } catch (error) {
        //console.log(error);
      }
      try {
        const res = {
          id: raw.id,
          imdburl: imdbUrl,
          name: raw.name,
          status: raw.status,
          rating: rating,
          image: image,
          nextepisode: nextepisode,
          isWatching: isWatching
        };
        setSearchResults(res)
      } catch (error) {
        //console.log(error);
        setSearchResults();
      }
      //console.log(raw.externals.imdb);
    } else {
      setSearchResults();
    }

  }

  // Fetch popular shows
  const fetchPopularShows = async () => {
    
    const apiUrl = '/api/popularShows';
    const result = await fetch(apiUrl);
    const ids = await result.json();
    var shows = [];
    for(const id of ids){
      const apiUrl = 'https://api.tvmaze.com/shows/'+id+'?embed=nextepisode';
      const result = await fetch(apiUrl);
      const data = await result.json();
      shows.push(data);
  }
  return shows;
  };
  // Fetch search results
  const fetchSearchResults = async (input) => {
    const apiUrl = 'https://api.tvmaze.com/singlesearch/shows?q='+input+'&embed=nextepisode';
    const result = await fetch(apiUrl);
    const data = await result.json();

    return data;
  }
  // Fetch social links
  const fetchSocialLinks = async () => {
    const apiUrl = '/api/social';
    const result = await fetch(apiUrl);
    const data = await result.json();
    return data;
  }

  return (
      <BrowserRouter>
          <Container className="App">
            <Header></Header>
              <Route path="/" exact render={(props) => (
                <>
                  <Search watchlist={watchlist} setWatchlist={setWatchlist} cookies={cookies} setCookie={setCookie} getSearchResults={getSearchResult} searchResults={searchResults}></Search>
                  <PopularShows watchlist={watchlist} setWatchlist={setWatchlist} cookies={cookies} setCookie={setCookie} popularShows={popularShows}></PopularShows>
                </>
              )}/>
              <Route path="/about" exact render={(props) => (
                <>
                  <About socialLinks={socialLinks}></About>
                </>
              )}/>
                <Route path="/watchlist" exact render={(props) => (
                <>
                  <Watchlist watchlist={watchlist} setWatchlist={setWatchlist} cookies={cookies} setCookie={setCookie}></Watchlist>
                </>
              )}/>
            <Footer socialLinks={socialLinks}></Footer>
          </Container>

      </BrowserRouter>

  );
}

export default Root;

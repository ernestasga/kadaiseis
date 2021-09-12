import { Badge, Card, Col, OverlayTrigger, Row, Tooltip } from "react-bootstrap"
import WatchlistButton from "./WatchlistButton";
import { useState } from 'react';

const Show = ({watchlist, setWatchlist, show, setCookie}) => {
    const [isWatching, setIsWatching] = useState(show.isWatching);
    var airdate = null;
    try {
        var dt = show.nextepisode != null ? new Date(show.nextepisode.airdate) : null;
        airdate = dt.toLocaleDateString('lt-LT', { weekday: 'short', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' });
    } catch (error) {

    }
    const renderTooltip = (props) => (
        <Tooltip id="button-tooltip" {...props}>
          Kitos serijos išleidimas Jūsų įrenginio laiku
        </Tooltip>
    );
    // Toggle watchlist
    const toggleWatchlistItem = () => {
        show.isWatching = !show.isWatching;
        setIsWatching(!isWatching);
        if(show.isWatching){
            watchlist.push(show.id);
        }else{
            const index = watchlist.indexOf(show.id)
            if(index > -1){
                watchlist.splice(index, 1)
            }
        }
        setCookie('watchlist', watchlist);
        setWatchlist(watchlist)
    }
    return (
            <Card className="mb-5">
                <Card.Header>
                    <h5>{show.name}</h5>
                    <WatchlistButton onClick={() => toggleWatchlistItem()} isWatching={show.isWatching}></WatchlistButton>
                </Card.Header>
                <Card.Img src={show.image}/>
                <Row>
                    {
                        show.imdburl !=null ?
                        <Col>
                            <a rel="noreferrer" target="_blank" href={show.imdburl} className="imdb-logo">IMDb {show.rating}</a> 
                        </Col>:
                        ''
                    }

                </Row>
                {
                    show.nextepisode != null ?
                    <Row className="mt-2">
                        <Col xs="12" sm="6">
                            <a rel="noreferrer" target="_blank" href={show.nextepisode.url}>
                                <Badge className="Next-ep-badge badge-danger badge">{show.nextepisode.episode}</Badge>
                            </a>
                        </Col>
                        <Col xs="12" sm="6">
                            <OverlayTrigger
                                placement="top"
                                overlay={renderTooltip}>
                                
                                <Badge className="Next-ep-badge badge-success badge text-wrap" bg="success">
                                    {   
                                        airdate != null ?
                                        airdate :
                                        ''
                                    }
                            
                                </Badge>
                            </OverlayTrigger>
                        </Col>
                    </Row> : ''
                }

            </Card>
    )
}

export default Show

import { Col, Row } from "react-bootstrap"
import Show from "./Show"

const PopularShows = ({watchlist, setWatchlist, popularShows, cookies, setCookie}) => {
    return (
        <div>
            <h1 className="text-white">Populiarūs serialai</h1>
            
                <Row>
                    {
                        popularShows.map((show) => (
                            <Col key={show.id} sm="6" md="4" lg="3">
                                <Show watchlist={watchlist} setWatchlist={setWatchlist} cookies={cookies} setCookie={setCookie} key={show.id} show={show}></Show>
                            </Col>
                        ))
                    }
                </Row>
        </div>
    )
}

export default PopularShows
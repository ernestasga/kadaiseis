import { Col, Row } from "react-bootstrap"
import Show from "./Show"

const Search = ({watchlist, setWatchlist, getSearchResults, searchResults, cookies, setCookie}) => {
    const onChange = async (value) => {
        getSearchResults(value);
        //this.setState();
    }
    return (
        <div>
            <h1 className="Page-title">Kada išeis kita serija?</h1>
            <input className="Search-input-box" placeholder="Ieškok serialo..." onChange={(e) => onChange(e.target.value)}></input>
            {
                searchResults != null ?
                <Row className="justify-content-center">
                    <Col className="px-1" xs="6" sm="6" md="4" lg="3">
                        <Show watchlist={watchlist} setWatchlist={setWatchlist} cookies={cookies} setCookie={setCookie} show={searchResults}></Show>
                    </Col>
                </Row> :
                ''
            }
        </div>
    )
}

export default Search


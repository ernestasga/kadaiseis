import { Button } from "react-bootstrap"

const WatchlistButton = ({isWatching, onClick}) => {

    return (
        <Button onClick={onClick} variant={isWatching ? 'danger' : 'success'}>{isWatching ? 'Nebesekti' : 'Sekti'}</Button>
    )
}

export default WatchlistButton

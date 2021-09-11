import { Card } from "react-bootstrap"

const About = ({socialLinks}) => {
    return (
        <div>
            <Card>
                <Card.Header>Apie</Card.Header>
                <Card.Text>
                    <p>
                    Ar dažnai pagalvoji arba Tavęs klausia "Kada išies 
                    X serialo kita serija?", bet tingi ieškoti informacijos IMDb? 
                    Nuo dabar gali greitai pasitikrinti visų savo žiūrimų serialų kitos serijos 
                    išleidimo datas vienoje vietoje!
                    </p>
                </Card.Text>
                <Card.Text>Ernestas G.</Card.Text>
                <Card.Text>garjonisernestas@gmail.com</Card.Text>
                <Card.Text><a href={socialLinks.facebook}>{socialLinks.facebook}</a></Card.Text>
                <Card.Text>Powered by TVMaze</Card.Text>
            </Card>
        </div>
    )
}

export default About

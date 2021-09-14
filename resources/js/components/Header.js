import React from 'react'
import { Navbar, Container, Nav } from "react-bootstrap"
import { NavLink } from "react-router-dom"

const Header = () => {
    return (
          <div className="App-header">


          <Navbar collapseOnSelect expand="lg">
              <Container>
              <NavLink to="/" className="text-white navbar-brand"><img width="200px" className="img img-responsive" src="/images/logo-text.png"/></NavLink>
              <Navbar.Toggle aria-controls="responsive-navbar-nav" className="navbar-dark"/>
              <Navbar.Collapse id="responsive-navbar-nav">
              <Nav className="ml-auto">
                <NavLink to="/watchlist" className="text-white nav-link"><b>Mano serialai</b></NavLink>
                <NavLink to="/about" className="text-white nav-link"><b>Apie</b></NavLink>
              </Nav>

              </Navbar.Collapse>
              </Container>
            </Navbar> 
          </div>
    )
}

export default Header

const Footer = ({socialLinks}) => {
    return (
        <footer className="footer footer-bottom d-flex flex-column">
            <p className="text-center text-white">
                kadaiseis.lt - by Ernestas G. {new Date().getFullYear()}
            </p>
            <div>
                <a className="facebook socialicons" href={socialLinks.facebook} title="Facebook " target="_blank">f</a>
            </div>
        </footer>
    )
}

export default Footer


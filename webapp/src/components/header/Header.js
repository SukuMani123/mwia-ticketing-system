import "./Header.css";

const Header = () => {
  
  return (
    <div className="header-container">
      <div className="logo-container">
        <img className="logo-img" src="https://indianassociation-mainz-wiesbaden.de/wp-content/uploads/2024/02/mmi_logo_v3.png" alt="logo" />
      </div>
      <div className="text-container">
        <h1 className="h1">Mainz Wiesbaden Indian Association</h1>
        <h2 className="h2">Registration for Grill Party - 2024</h2>
      </div>
    </div>
  );
};

export default Header;

import RegistrationForm from "./RegistrationForm";
import "./RegistrationForm.css";
import Header from "../../header/Header";
const RegistrationFrame = () => {
  return (
    <>
      <div className="App">
       <Header/>
        <hr className="divider" />
        <div className="text-container">
        <h2 className="h2">
          Mainz-Wiesbaden Indian Association (MWIA) inviting You and Your Family
          to be part of Our Summer Grill Fest
        </h2>
        </div>
        <RegistrationForm />
      </div>
    </>
  );
};

export default RegistrationFrame;

import { BrowserRouter, Route, Routes } from "react-router-dom";
//import "./App.css";
import RegistrationFrame from "./components/pages/RegistrationFrame";
import RegistrationPaymentPage from "./components/pages/RegistrationPaymentPage";
import TermsConditions from "./components/pages/TermsConditions";
import SuccessPage from "./components/pages/SuccessPage";
function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<RegistrationFrame />} />
        <Route
          path="/RegistrationPaymentPage"
          element={<RegistrationPaymentPage />}/>
        <Route path="/TermsConditions" element={<TermsConditions />} />
        <Route path="/SuccessPage" element={<SuccessPage />} />    
      </Routes>
    </BrowserRouter>
  );
}

export default App;

import { BrowserRouter, Route, Routes } from "react-router-dom";
import RegistrationPaymentPage from "./components/pages/payment/RegistrationPaymentPage";
import TermsdConditions from "./components/pages/term&conditions/TermsConditions";
import SuccessPage from "./components/pages/success/SuccessPage";
import FailurePage from "./components/pages/failure/FailurePage";
import RegistrationFrame from "./components/pages/RegistrationPage/RegistrationFrame"
function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<RegistrationFrame/>} />
        <Route
          path="/RegistrationPaymentPage"
          element={<RegistrationPaymentPage />}/>
        <Route path="/TermsConditions" element={<TermsdConditions />} />
        <Route path="/SuccessPage" element={<SuccessPage />} />    
        <Route path="/Failure" element={<FailurePage />} />    

      </Routes>
    </BrowserRouter>
  );
}

export default App;

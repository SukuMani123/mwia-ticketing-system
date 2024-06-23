import Headers from "../../header/Header";
import React from "react";
import { useLocation } from "react-router-dom";
import PayPalButton from "./PaypalButton";
const RegistrationPaymentPage = () => {
  const location = useLocation();
  const { data } = location.state;
 // console.log("Received Data:", data);

  return (
    <>
      <div className="App">
       <Headers/>
        <hr className="divider" />
        <div className="text-container">
          <h2 className="h2">
            Mainz-Wiesbaden Indian Association (MWIA) inviting You and Your
            Family to be part of Our Summer Grill Fest
          </h2>
        </div>
        <div className="form-container">
          <p className="h2small">EmailId : {data.emailId}</p>
          <hr className="dividerSpace" />
          <p className="h2small">No. Adult : {data.nubmberOfAdult}</p>
          <p className="h2small">No. Kids 6-12 : {data.nubmberOfKids_age_above6}</p>

          <p className="h2small">No. Kids 0-6 : {data.nubmberOfKids_age_below6}</p>
          <p className="h2">Total : {data.totalAmount} €</p>

          <div className="text-container">
            <PayPalButton
              amount={data.totalAmount}
              paymentReferenceNumber={data.paymentReference}
              />
          </div>
        </div>
      </div>
    </>
  );
};

export default RegistrationPaymentPage;

import Headers from "../header/Header";
import { useLocation } from 'react-router-dom';
import { useNavigate } from "react-router-dom";
import React, { useEffect } from 'react';
const FailedPaymentPage = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const queryParams = new URLSearchParams(location.search);

  const paymentReferenceNumber = queryParams.get('paymentReferenceNumber');
  const payerid = queryParams.get("PayerID");
  const handleClick = (e) => {
    e.preventDefault();
    navigate("https://indianassociation-mainz-wiesbaden.de/");
  };
  useEffect(() => {
    // Define the API URL and parameters
    const apiUrl = `https://indianassociation-mainz-wiesbaden.de/eventregistration/api/confirmRegistration.php?paymentReferenceNumber=${paymentReferenceNumber}&paidstatus=1&payerid=${payerid} `;

    // Call the API
    const callApi = async () => {
      try {
        const response = await fetch(apiUrl);
        if (response.ok) {
          const data = await response.json();
          // Handle the API response data as needed
        } else {
          console.error('API call failed:', response.status);
        }
      } catch (error) {
        //console.error('API call error:', error);
      }
    };
    callApi();
  }, [paymentReferenceNumber]);


  return (
    <>
      <div className="App">
        <Headers />
        <hr className="divider" />
        <div className="text-container">
          <h2 className="h2">
            Mainz-Wiesbaden Indian Association (MWIA) inviting You and Your
            Family to be part of Our Summer Grill Fest
          </h2>
        </div>
        <div className="form-container">
          <h2>Your payment failed</h2>
          <hr className="dividerSpace26" />
          <p className="h2small">
            Please contact MWIA team {" "}
          </p>
          <div className="text-container">
            <button
              style={{ backgroundColor: "#D9D9D9", color: "black" }}
              onClick={handleClick}
              type="button"
            >
              Go Home
            </button>
          </div>
        </div>
      </div>
    </>
  );
};

export default FailedPaymentPage;

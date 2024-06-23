import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Link } from "react-router-dom";
import "./RegistrationForm.css";
import RegistrationPaymentPage from "./RegistrationPaymentPage";

const RegistrationForm = () => {
  const [showAlert, setShowAlert] = useState(false);
  const [isChecked, setIsChecked] = useState(false);
  const navigate = useNavigate();

  const isEmail = (email) => /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(email);

  const [formData, setFormData] = useState({
    eventId: "GRILL",
    emailId: "",
    fullName: "",
    address: "",
    mobileNumber: "",
    paymentReferenceNumber: "",
    noAdults: "",
    noKidsBelow6: "",
    noKidsAbove6: "",
    isMember: false,
    memberId: "",
    isRegisteredCurrentEvent: false
  });
  const handleCheckboxChange = (event) => {
    setIsChecked(event.target.checked);
  };

  const [posts, setPosts] = useState([]);

  const handleClick = () => {
    console.log(isFormValid);

    // if (isFormValid) {
    postApi(formData);
    //}
  };

  const [isFormValid, setIsFormValid] = useState(false);

  useEffect(() => {
    const checkFormValidity = () => {
      const {
        emailId,
        fullName,
        address,
        mobileNumber,
        noAdults,
        noKidsAbove6
      } = formData;
      const isValid =
        emailId &&
        fullName &&
        address &&
        mobileNumber &&
        noAdults &&
        noKidsAbove6 &&
        isChecked;
      setIsFormValid(isValid);
    };

    checkFormValidity();
  }, [formData, isChecked]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });

    if (name === "email" && value && isEmail(value)) {
      fetch(
        `https://indianassociation-mainz-wiesbaden.de/eventregistration/api/user.php?userid=${value}&&eventid=GRILL;`
      )
        .then((response) => response.json())
        .then((data) => {
          console.log("Ramesh Success user:", data);
          setPosts(data);
          if (data.isMember) {
            setShowAlert(data.isRegisteredCurrentEvent);
            const {
              email,
              fullName,
              fullAddress,
              nubmberOfAdult,
              nubmberOfKids_age_above6,
              nubmberOfKids_age_below6,
              contactNumber,
              paymentReference,
              memberId,
              eventId,
              isRegisteredCurrentEvent
            } = data;
            setFormData({
              eventId: "GRILL",
              emailId: email,
              fullName: fullName,
              address: fullAddress,
              mobileNumber: contactNumber,
              paymentReferenceNumber: paymentReference,
              noAdults: nubmberOfAdult,
              noKidsBelow6: nubmberOfKids_age_below6,
              noKidsAbove6: nubmberOfKids_age_above6,
              isMember: data.isMember,
              memberId: data.memberId,
              isRegisteredCurrentEvent: data.isRegisteredCurrentEvent
            });
          } else {
            const {
              email,
              fullName,
              fullAddress,
              nubmberOfAdult,
              nubmberOfKids_age_above6,
              nubmberOfKids_age_below6,
              contactNumber,
              paymentReference,
              memberId,
              eventId,
              isRegisteredCurrentEvent
            } = data;
            setFormData({
              eventId: "GRILL",
              emailId: value,
              fullName: "",
              address: "",
              mobileNumber: "",
              noAdults: "",
              noKidsBelow6: "",
              noKidsAbove6: "",
              isMember: false,
              memberId: "",
              isRegisteredCurrentEvent: false,
              paymentReferenceNumber: paymentReference,
            });
          }
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    }
  };

  const postApi = (data) => {
    const postData = new FormData();
    postData.append("eventId", data.eventId);
    postData.append("emailId", data.emailId);
    postData.append("fullName", data.fullName);
    postData.append("address", data.address);
    postData.append("mobileNumber", data.mobileNumber);
    postData.append("paymentReferenceNumber", data.paymentReferenceNumber);
    postData.append("noAdult", data.noAdults);
    postData.append("noKidsBelow6", data.noKidsBelow6);
    postData.append("noKidsAbove6", data.noKidsAbove6);
    postData.append("memberId", data.memberId);
    //postData.append('isMember', data.isMember);

    console.log(postData);

    fetch(
      "https://indianassociation-mainz-wiesbaden.de/eventregistration/api/registerEvent.php",
      {
        method: "POST",
        body: postData
      }
    )
      .then((response) => {
        console.log("Response Log", response);
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        console.log("Ramesh Success:", data);
        if(data!=null){
        navigate("/RegistrationPaymentPage", { state: { data } });
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
  };

  return (
    <div className="form-container">
      <p className="h2small">MWIA Member : 12€</p>
      <p className="h2small">Non-Member : 15€</p>
      <p className="h2small">Children (age 6 - 12) : 5€</p>
      <p className="h2small">Kids (age 0 - 6) : 0€</p>
      <p className="h2small">Program start from 11:00 AM , 20 July 2024</p>
      <hr className="dividerSpace" />

      <form onSubmit={handleSubmit}>
        <div className="form-row">
          <label style={{ textAlign: "left" }}>Email id: </label>
          <input
            type="email"
            name="email"
            value={formData.email}
            onChange={handleChange}
            required
          />
        </div>

        <div className="form-row">
          <span className="instruction">
            If you are a member of MWIA, please make sure to enter the same
            email id
          </span>
        </div>

        <div className="form-row">
          <label style={{ textAlign: "left" }}>Full Name: </label>
          <input
            type="text"
            name="fullName"
            value={formData.fullName}
            onChange={handleChange}
            required
          />
        </div>

        <div className="form-row">
          <label style={{ textAlign: "left" }}>Address: </label>
          <input
            type="text"
            name="address"
            value={formData.address}
            onChange={handleChange}
            required
          />
        </div>

        <div className="form-row">
          <label style={{ textAlign: "left" }}>No. Adults: </label>
          <input
            type="number"
            name="noAdults"
            value={formData.noAdults}
            onChange={handleChange}
            min="0"
            required
          />
        </div>

        <div className="form-row">
          <label style={{ textAlign: "left" }}>
            No. Children (Age 6 - 12):{" "}
          </label>
          <input
            type="number"
            name="noKidsAbove6"
            value={formData.noKidsAbove6}
            onChange={handleChange}
            min="0"
            required
          />
        </div>

        <div className="form-row">
          <label style={{ textAlign: "left" }}>No. Kids (Age 0 - 6): </label>
          <input
            type="number"
            name="noKidsBelow6"
            min="0"
            value={formData.noKidsBelow6}
            onChange={handleChange}
          />
        </div>

        <div className="form-row">
          <label style={{ textAlign: "left" }}>Contact number: </label>
          <input
            type="text"
            name="mobileNumber"
            value={formData.mobileNumber}
            onChange={handleChange}
            required
          />
        </div>

        <div className="form-row">
          <input
            style={{ marginRight: "20px" }}
            type="checkbox"
            checked={isChecked}
            onChange={handleCheckboxChange}
          />

          <p>
            by clicking submit you agree to the
            <Link style={{marginLeft:"10px"}}
              to="/TermsConditions"
              target="_blank"
              rel="noopener noreferrer"
            >
              terms and conditions
            </Link>
          </p>
        </div>
        <button onClick={handleClick} type="submit" disabled={!isFormValid}>
          Submit
        </button>
      </form>
    </div>
  );
};

export default RegistrationForm;

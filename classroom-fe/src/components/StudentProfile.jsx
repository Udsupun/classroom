import React from "react";

const StudentProfile = ({ loading, name, grade, address }) => {
  return (
    <div className="student-profile">
      {loading ? (
        <h3>Loading...</h3>
      ) : (
        <div>
          <h3>Name: {name}</h3>
          <h3>Grade: {grade}</h3>
          <h3>Address: {address}</h3>
        </div>
      )}
    </div>
  );
};

export default StudentProfile;

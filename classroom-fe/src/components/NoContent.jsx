import React from 'react';

const NoContent = ({ message = "No content available" }) => {
  return (
    <div className="no-content-banner">
      <p>{message}</p>
    </div>
  );
};

export default NoContent;

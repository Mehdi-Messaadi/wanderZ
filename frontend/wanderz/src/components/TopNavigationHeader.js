import React from "react";
import TopNavigationHeaderMenu from "./TopNavigationHeaderMenu.js";
import "../styles/topNavigationHeader.scss";

function TopNavigationBar() {
  return (
    <div className="TopNavigationHeader">
      <TopNavigationHeaderMenu />
    </div>
  );
}

export default TopNavigationBar;

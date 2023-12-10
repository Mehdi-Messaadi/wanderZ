import React, { useState } from "react";
import "../styles/topNavigationHeaderMenu.scss";

function TopNavigationHeaderMenu() {
  const [activeMenu, setActiveMenu] = useState(null);

  const handleButtonClick = (menuName) => {
    setActiveMenu(activeMenu === menuName ? null : menuName); // Toggle menu visibility
  };

  return (
    <div className="TopNavigationHeaderMenu">
      <nav className="TopNavigationHeaderMenu-Nav-Desktop">
        <ul className="TopNavigationHeaderMenu-Nav-List">
          {[
            "MEN",
            "WOMEN",
            "KIDS",
            "SOCKS",
            "GIFTS",
            "SUSTAINABILITY",
            "RERUN",
          ].map((menuName) => (
            <li
              className="TopNavigationHeaderMenu-Nav-List-PrimaryItem"
              key={menuName}
            >
              <div className="TopNavigationHeaderMenu-Nav-List-PrimaryItem-ButtonWrapper">
                <button
                  className="TopNavigationHeaderMenu-Nav-List-PrimaryItem-Button"
                  onClick={() => handleButtonClick(menuName)}
                >
                  <div className="TopNavigationHeaderMenu-Nav-List-PrimaryItem-ButtonContent">
                    <p className="TopNavigationHeaderMenu-Nav-List-PrimaryItem-ButtonLabel">
                      {menuName}
                    </p>
                  </div>
                </button>
              </div>
            </li>
          ))}
        </ul>
      </nav>
    </div>
  );
}

export default TopNavigationHeaderMenu;

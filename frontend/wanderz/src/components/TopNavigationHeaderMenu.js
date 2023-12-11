import React, { useState } from "react";
import { useQuery, gql } from "@apollo/client";
import "../styles/topNavigationHeaderMenu.scss";

function TopNavigationHeaderMenu() {
  const [activeMenu, setActiveMenu] = useState(null);

  const handleButtonClick = (menuName) => {
    const category = data.categories.find((c) => c.category_title === menuName);
    if (
      category &&
      category.subcategories &&
      category.subcategories.length > 0
    ) {
      // Open drawer if subcategories are present
      setActiveMenu(activeMenu === menuName ? null : menuName);
    } else {
      // Navigate to a different page if no subcategories
    }
  };

  const GET_CATEGORIES = gql`
    query getCategories {
      categories {
        category_title
        subcategories {
          title
          subcategories
        }
      }
    }
  `;

  const { loading, error, data } = useQuery(GET_CATEGORIES);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error :(</p>;

  return (
    <div className="TopNavigationHeaderMenuContainer">
      <div className="TopNavigationHeaderMenu-Desktop">
        <nav className="TopNavigationHeaderMenu-Desktop-Nav">
          <ul className="TopNavigationHeaderMenu-Desktop-Nav-List">
            {data.categories.map((category) => (
              <li
                className="TopNavigationHeaderMenu-Desktop-Nav-List-PrimaryItem"
                key={category.category_title}
              >
                <button
                  className="TopNavigationHeaderMenu-Desktop-Nav-List-PrimaryItem-Button"
                  onClick={() => handleButtonClick(category.category_title)}
                >
                  <p className="TopNavigationHeaderMenu-Desktop-Nav-List-PrimaryItem-ButtonLabel">
                    {category.category_title}
                  </p>
                </button>
              </li>
            ))}
          </ul>
        </nav>
      </div>
      {activeMenu && (
        <div className="TopNavigationHeaderMenu-Desktop-Drawer">
          <ul className="TopNavigationHeaderMenu-Desktop-Drawer-List">
            {data.categories
              .find((c) => c.category_title === activeMenu)
              ?.subcategories.map((subcategory) => (
                <li
                  className="TopNavigationHeaderMenu-Desktop-Drawer-List-Item"
                  key={subcategory.title}
                >
                  <h1 className="TopNavigationHeaderMenu-Desktop-Drawer-List-Item-Title">
                    {subcategory.title}
                  </h1>
                  <ul className="TopNavigationHeaderMenu-Desktop-Drawer-List-SubItem">
                    {subcategory.subcategories.map((subSubcategory) => (
                      <li
                        className="TopNavigationHeaderMenu-Desktop-Drawer-List-SubItem-Item"
                        key={subSubcategory}
                      >
                        <a
                          className="TopNavigationHeaderMenu-Desktop-Drawer-List-SubItem-Item-Link"
                          href=""
                        >
                          <p className="TopNavigationHeaderMenu-Desktop-Drawer-List-SubItem-Item-Link-Label">
                            {subSubcategory}
                          </p>
                        </a>
                      </li>
                    ))}
                  </ul>
                </li>
              ))}
          </ul>
        </div>
      )}
    </div>
  );
}

export default TopNavigationHeaderMenu;

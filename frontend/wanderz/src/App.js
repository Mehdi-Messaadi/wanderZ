import React from "react";
import { useQuery, gql } from "@apollo/client";
import TopNavigationBanner from "./components/TopNavigationBanner.js";
import TopNavigationHeader from "./components/TopNavigationHeader.js";

import "./styles/app.scss";

function App() {
  const GET_PRODUCTS = gql`
    query GetProducts {
      products {
        id
        sku
        name
        uri
        category
        price
        score
        description
      }
    }
  `;

  const { loading, error, data } = useQuery(GET_PRODUCTS);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error :(</p>;

  return (
    <div className="App">
      <TopNavigationBanner />
      <TopNavigationHeader />
      <h1>I am NOT a vegan!!</h1>
      <div>
        {data.products.map((product) => (
          <div key={product.id}>
            <h3>{product.name}</h3>
          </div>
        ))}
      </div>
    </div>
  );
}

export default App;

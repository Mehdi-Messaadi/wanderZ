import React from "react";
import ReactDOM from "react-dom/client";
import { ApolloClient, InMemoryCache, ApolloProvider } from "@apollo/client";
import App from "./App";

const client = new ApolloClient({
  uri: "http://localhost/wanderZ/wanderZ/index.php", // Change this to your GraphQL server URI
  cache: new InMemoryCache(),
});

// Initialize the concurrent root
const root = ReactDOM.createRoot(document.getElementById("root"));

// Render the App component using ApolloProvider in Concurrent Mode
root.render(
  <ApolloProvider client={client}>
    <App />
  </ApolloProvider>
);

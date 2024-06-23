import React, { useEffect, useState } from "react";

const Fetchapi = () => {
  const [posts, setPosts] = useState([]);
  useEffect(() => {
    fetch("https://indianassociation-mainz-wiesbaden.de/eventregistration/api/user.php?userid=ramrc007@gmail.com")
      .then((response) => response.json())
      .then((posts) => setPosts(posts.splice(0,10)));
  }, []);

  return (
    <div>
      <p>Fetch API</p>

      {posts.map((data) => (
        <div key={data.id}  className="bg-dark">
          <h1 className="text-info">{data.title}</h1>
          <p className="text-white">{data.body}</p>
        </div>
      ))}
    </div>
  );
};

export default Fetchapi;

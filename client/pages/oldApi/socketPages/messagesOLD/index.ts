import { getServerSession } from "next-auth/next";
import { authOptions } from "@/lib/auth";
import { NextApiResponseServerIo } from "@/Types";
import { NextApiRequest, NextApiResponse } from "next";

const protectedContentHandler = async (req: NextApiRequest, res: NextApiResponse) => {
  const session = await getServerSession(req, res, authOptions);
  if (session) {
    res.send({
      content:
        "This is protected content. You can access this content because you are signed in.",
    });
  } else {
    res.send({
      error: "You must be signed in to view the protected content on this page.",
    });
  }
};

export default protectedContentHandler;
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <style>
        .clearfix:after {
        content: "";
        display: table;
        clear: both;
        }

        a {
        color: #5D6975;
        text-decoration: underline;
        }

        body {
        position: relative;
        width: 70%;  
        height: 100%; 
        margin: 0 auto; 
        color: #001028;
        background: #FFFFFF; 
        font-family: Arial, sans-serif; 
        font-size: 12px; 
        font-family: Arial;
        }

        header {
        padding: 10px 0;
        margin-bottom: 30px;
        }

        #logo {
        text-align: center;
        margin-bottom: 10px;
        }

        #logo img {
        width: 90px;
        }

        h1 {
        color: #5D6975;
        font-size: 2.4em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        background: url('app-assets/images/invoice/dimension.png');
        }

        #project {
        float: left;
        }

        #project span {
        color: #5D6975;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.8em;
        }

        #company {
        float: right;
        text-align: right;
        }

        #project div,
        #company div {
        white-space: nowrap;        
        }

        table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
        background: #F5F5F5;
        }

        table th,
        table td {
        text-align: left;
        }

        table th {
        padding: 5px 20px;
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;        
        font-weight: normal;
        }

        table .service,
        table .desc {
        text-align: left;
        }

        table td {
        padding: 20px;
        }

        table td.service,
        table td.desc {
        vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
        font-size: 1.2em;
        }

        table td.grand {
        border-top: 1px solid #5D6975;;
        }
        #notices {
            padding: 3rem 0;
            border-top: 1px solid #C1CED9;
        }
        #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{ url('app-assets/images/logo/logo.png')}}">
      </div>
      <h1>Receipt from Stripe, Inc.</h1>
      <span>Receipt #1499-7244</span>
    </header>
    <main>
        <table>
            <tbody>
                <tr>
                    <td>AMOUNT PAID</td>
                    <td>DATE PAID</td>
                    <td>PAYMENT METHOD</td>
                </tr>
                <tr>
                    <td>$39</td>
                    <td>March 13, 2021</td>
                    <td><b>VISA</b>-9969</td>
                </tr>
            </tbody>
        </table>
      <table>
        <strong>SUMMARY</strong>
        <tbody>
          <tr>
            <td class="service">Payment to Stripe, Inc</td>
            <td class="paid">$39.00</td>
          </tr>
          <tr>
            <td class="service">Amount paid</td>
            <td class="paid">$39.00</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">If you have any questions, contact us at shop@strip.com or call at +1 555 123-4567.</div>
      </div>
    </main>
    <footer>
      <p>Something wrong with the email? <a>View it in your browser</a></p>
      <p>You are receiving this email because you made a purchase at Stripe, Inc. Stripe, Inc parters with Stripe to provide secure invoicing and payments processing.</p>
        <p>Stripe, 510 Townsend Street, San Francisco CA 94103</p>
        <p>Application Name: Stripe Credit, AID: A00000000031010</p>

    </footer>
  </body>
</html>
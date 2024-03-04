//
//  CartViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 28/12/22.
//

import UIKit

class CartViewController: UIViewController {
    // MARK: @IBOutlets--
    @IBOutlet weak var ticketDataTableView: UITableView!
    @IBOutlet weak var lblEmpty: UILabel!
    // MARK: Variable initializer--
    var cartData : CartModelData?
    lazy var cartViewModel:CartViewModel = {
        var cartViewModel = CartViewModel()
        return cartViewModel
    }()
    var ticketCount: Int?
    
    // MARK: View Life Cycle
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        ticketDataTableView.delegate = self
        ticketDataTableView.dataSource = self
        
    }
    // MARK: CheckOut APi call--
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        CheckOutApiCall()
    }
    
    // MARK: PlaceOrder Api Call--
    @IBAction func placeOrderActionButton(_ sender: UIButton) {
        if cartData?.data?.cartDatas?.count != 0{
            let vc = self.storyboard?.instantiateViewController(withIdentifier: PaymentCheckoutViewController.identifier) as! PaymentCheckoutViewController
            vc.cartData = cartData
            vc.quantity = Int(ticketCount ?? 0)
            self.navigationController?.pushViewController(vc, animated: false)
        }
    }
    // MARK: Function for Increase Button Action
    /// Create Function For increase the value and show in label
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapIncreaseBtn(sender: UIButton){
        if (ticketCount ?? 0) < (cartData?.data?.cartDatas?.first?.ticket?.quantity ?? 0){
            ticketCount = (ticketCount ?? 0) + 1
            updateCart()
            self.ticketDataTableView.reloadData()
        }else{
            self.showSimpleAlert(message: AppMessage.shared.NoMoreticket)
        }
    }
    // MARK: Function for Decrease Button Action
    /// Create Function For decrease the value and show in label
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapDecreaseBtn(sender: UIButton){
        if (ticketCount ?? 0) > 1{
            ticketCount = (ticketCount ?? 0) - 1
            updateCart()
            self.ticketDataTableView.reloadData()
        }
        
    }
    // MARK: Button action Delete Cart APi Call--
    /// Create Function For buy Delete Cart
    /// - Parameter sender: UIButton
    /// return :nil
    @objc func deleteCartItem(sender: UIButton){
        cartViewModel.callDeleteCartApi(id: cartData?.data?.cartDatas?.first?.id ?? 0) { deleteCartData, IsSuccess in
            if IsSuccess == true{
                self.showSimpleAlert(message: deleteCartData?.message ?? DefaultValue.errorMsg.rawValue)
                self.CheckOutApiCall()
            }else{
            }
        }
    }
    // MARK: Create function for Check Out APi Call--
    /// Create Function For Check Out
    /// - Parameter sender: UIButton
    /// return :nil
    func CheckOutApiCall(){
        cartViewModel.callCheckOutApi{ [weak self]cartDetails, isSuccess in
            if isSuccess == true{
                self?.cartData = cartDetails
                if cartDetails.data?.cartDatas?.count ?? 0 > 0 {
                    self?.lblEmpty.isHidden = true
                    self?.ticketDataTableView.isHidden = false
                } else {
                    self?.lblEmpty.isHidden = false
                    self?.ticketDataTableView.isHidden = true
                }
                self?.ticketCount = cartDetails.data?.cartDatas?.first?.quantity ?? 0
                self?.ticketDataTableView.reloadData()
            } else {
                self?.showSimpleAlert(message: cartDetails.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Create function for updateCart APi Call--
    /// Create Function For  updateCart
    /// - Parameter sender: UIButton
    /// return :nil
    func updateCart(){
        cartViewModel.callUpdateCartApi(userID: cartData?.data?.cartDatas?.first?.userID ?? 0, ticketID: cartData?.data?.cartDatas?.first?.ticket?.id ?? 0, quantity: ticketCount ?? 0) {[weak self] updateCartData, isSuccess in
            if isSuccess == true{
            }else{
                self?.showSimpleAlert(message: updateCartData?.message ?? DefaultValue.errorMsg.rawValue)
            }}
    }}
// MARK: Create extension for tableview--
///show the required detail in tableview
extension CartViewController : UITableViewDelegate, UITableViewDataSource {
    
    func numberOfSections(in tableView: UITableView) -> Int {
        return 1
    }
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        let count = cartData?.data?.cartDatas?.count ?? 0
        return count > 0 ? 2 : 0
       
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
            if indexPath.row == 0 {
                let cell = tableView.dequeueReusableCell(withIdentifier: CartTableViewCell.identifier, for: indexPath)as!
                CartTableViewCell
                cell.eventTitle.text = cartData?.data?.cartDatas?.first?.ticket?.event?.eventTitle?.capitalized ?? DefaultValue.emptyString.rawValue
                cell.ticketTitle.text = cartData?.data?.cartDatas?.first?.ticket?.ticketTitle ?? DefaultValue.emptyString.rawValue
                cell.lblUnitPrice.text = "$\(cartData?.data?.cartDatas?.first?.ticket?.price ?? 0)"
                //            cell.lblShowQuantity.text = "\(cartData?.data?.cartDatas?.first?.quantity)"
                cell.lblShowQuantity.text = "\(ticketCount ?? 0)"
                cell.lblAmmount.text = "$\((ticketCount ?? 0) * Int(cartData?.data?.cartDatas?.first?.ticket?.price ?? 0))"
                cell.decreaseButton.tag = indexPath.row
                cell.increaseButton.tag = indexPath.row
                cell.increaseButton.addTarget(self, action: #selector(tapIncreaseBtn(sender: )), for: .touchUpInside)
                cell.decreaseButton.addTarget(self, action: #selector(tapDecreaseBtn(sender: )), for: .touchUpInside)
                cell.deleteButton.addTarget(self, action: #selector(deleteCartItem(sender: )), for: .touchUpInside)
                if let imageURL = cartData?.data?.cartDatas?.first?.ticket?.event?.eventImage{
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    cell.eventImage.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
                    }
                }else{
                    //cell.bannerImage.image =
                }
                return cell
            } else {
                let cell = tableView.dequeueReusableCell(withIdentifier: OrderDetailTableViewCell.identifier, for: indexPath)as! OrderDetailTableViewCell
                cell.lblPrice.text = "$\(cartData?.data?.cartDatas?.first?.ticket?.price ?? 0)"
                //            cell.lblDiscount
                cell.totalPrice.text = "$\((ticketCount ?? 0) * Int(cartData?.data?.cartDatas?.first?.ticket?.price ?? 0))"
                //cell.placeOrderButton.isUserInteractionEnabled = false
                return cell
            }
        }
}

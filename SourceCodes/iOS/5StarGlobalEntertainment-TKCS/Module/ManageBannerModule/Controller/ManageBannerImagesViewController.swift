//
//  ManageBannerImagesViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/03/23.
//

import UIKit
import SDWebImage

class ManageBannerImagesViewController: UIViewController {
    
    // MARK: IBOutlets--
    @IBOutlet weak var bannerTableView: UITableView!
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var lblNoRecord: UILabel!
    // MARK: Variable Initializer--
    var bannerDetailModel = ManageBannerModel()
    lazy var bannerImageViewModel:ManageBannerViewModel = {
        var bannerImageViewModel = ManageBannerViewModel()
        return bannerImageViewModel
    }()
    var manageBannerData: [BannerDetails]?
    var searchBannerData: [BannerDetails]?
    
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        bannerTableView.delegate = self
        bannerTableView.dataSource = self
        lblNoRecord.isHidden = true
        searchTextField.delegate = self
        getBannerAPi()
        bannerTableView.reloadData()
    }
//    // MARK: viewWillAppear--
    /// create function for calling get banner API
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        searchTextField.text = ""
        getBannerAPi()
    }
    // MARK: Create function for calling get Banner APi--
    func getBannerAPi(){
        bannerImageViewModel.callBannerImagesApi {[weak self] bannerData, isSuccess in
            if isSuccess == true{
                self?.manageBannerData = bannerData.data
                self?.searchBannerData = bannerData.data
                self?.bannerTableView.reloadData()
            }else{
                self?.showSimpleAlert(message: bannerData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Back Button Action--
    /// Create Action for navigate to previous Screen
    /// - Parameter sender : UIButton
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Button action Edit Category APi Call--
    /// Create Function For Edit Category
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapEditBtn(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: EditBannerViewController.identifier) as! EditBannerViewController
        vc.updateBannerViewModel.id = searchBannerData?[sender.tag].id ?? 0
        self.navigationController?.pushViewController(vc , animated: true)
    }
    // MARK: Button action Delete Category APi Call--
    /// Create Function For Delete Category
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapDeleteBtn(sender: UIButton){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeleteUser, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
            self.bannerImageViewModel.callDeleteBannerApi(id: self.searchBannerData?[sender.tag].id ?? 0) { [weak self] deleteBannerData, isSuccess in
                if isSuccess == true{
                    self?.showSimpleAlert(message: deleteBannerData?.message ?? DefaultValue.errorMsg.rawValue)
                    self?.getBannerAPi()
                    self?.bannerTableView.reloadData()
                }else{
                    self?.showSimpleAlert(message: deleteBannerData?.message ?? DefaultValue.errorMsg.rawValue)
                }
            }}))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    @objc func bannerStatusChanged(_ sender : UISwitch!){
        debugPrint("Banner:- \(sender.tag)")
        let bannerID = manageBannerData?[sender.tag].id ?? 0
        let preStatus = manageBannerData?[sender.tag].status ?? 0
        var message = DefaultValue.emptyString.rawValue
        var toLiveStatus = 0
        switch preStatus {
        case 0:
            message = AppMessage.shared.ActivateBanner
            toLiveStatus = 1
        case 1:
            message = AppMessage.shared.DeactivateBanner
            toLiveStatus = 0
        default:
            break
        }
        let alert = UIAlertController(title: Alert.projectName, message: message, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action:UIAlertAction!) in
        self.changeBannerStatus(bannerID: bannerID, status: toLiveStatus)
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
        self.bannerTableView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
       
    }
    // MARK: Create function for calling ticket Status Api--
    func changeBannerStatus(bannerID: Int, status: Int){
        bannerImageViewModel.callBannerStatusApi(bannerId: bannerID, status: status) {[weak self] bannerStatus, isSuccess in
            if isSuccess == true{
                self?.refreshAlert(title: Alert.projectName, message: bannerStatus?.message ?? DefaultValue.errorMsg.rawValue)
                self?.getBannerAPi()
                self?.bannerTableView.reloadData()
                self?.showSimpleAlert(message: bannerStatus?.message ?? DefaultValue.errorMsg.rawValue)
            }else{
                self?.showSimpleAlert(message: bannerStatus?.message ?? DefaultValue.errorMsg.rawValue)
                self?.bannerTableView.reloadData()
            }}
    }
}

// MARK: Extenstion for Tableview delegate--
extension ManageBannerImagesViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {

        if searchBannerData?.count == 0{
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return searchBannerData?.count ?? 0
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: ManageBannerImagesTableViewCell.identifier) as! ManageBannerImagesTableViewCell
        let data = searchBannerData?[indexPath.row]
        cell.lblDescription.attributedText = data?.description?.convertHtmlToAttributedStringWithCSS(font: UIFont(name: DefaultValue.Arial.rawValue, size: 20), csscolor: DefaultValue.white.rawValue, lineheight: 5, csstextalign: DefaultValue.left.rawValue)
        if let imageURL = data?.bannerImage{
            let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
            cell.bannerImage.sd_imageIndicator = SDWebImageActivityIndicator.gray
            cell.bannerImage.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
            }
        }else{
            //cell.bannerImage.image =
        }
        cell.editButton.tag = indexPath.row
        cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
        cell.deleteButton.tag = indexPath.row
        cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
        cell.manageBannerStatus(status: data?.status ?? 0)
        cell.switchButton.tag = indexPath.row
        cell.switchButton.addTarget(self, action: #selector(self.bannerStatusChanged(_:)), for: .valueChanged)
        return cell
    }
    
}
// MARK: Extention for TextFiled Delegate--
///create function for seach data on basis of text--
extension ManageBannerImagesViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                searchBannerData = manageBannerData?.filter({ values in
                    return (values.description ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                })
            }else{
                searchBannerData = manageBannerData
            }
            bannerTableView.reloadData()
        }
        return true

    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}

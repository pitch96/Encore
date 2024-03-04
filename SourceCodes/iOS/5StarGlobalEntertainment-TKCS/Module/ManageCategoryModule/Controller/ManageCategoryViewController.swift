//
//  ManageCategoryViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 04/02/23.
//

import UIKit

class ManageCategoryViewController: UIViewController {
    // MARK: IBoutlets--
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var tableViewManageCategory: UITableView!
    @IBOutlet weak var lblNoRecord: UILabel!
    // MARK: Variable initializer
    var manageCategoryViewModel = ManageCategoryViewModel()
    var manageCategoryData: [ManagecategoryDetail]?
    var searchCategoryData: [ManagecategoryDetail]?
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
       
        // Do any additional setup after loading the view.
        tableViewManageCategory.delegate = self
        tableViewManageCategory.dataSource = self
        searchTextField.delegate = self
        lblNoRecord.isHidden = false
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Call manage Category API--
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        searchTextField.text = ""
        manageCategoryApi()
    }
    // MARK: Button action for navigation--
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: FSGHomeTabBarController.identifier) as! FSGHomeTabBarController
        self.navigationController?.pushViewController(vc , animated: true)
        // self.navigationController?.popViewController(animated: true)
        
    }
    // MARK: Create a function for Calling get CategoryById--
    func manageCategoryApi(){
        manageCategoryViewModel.callManageCategoryApi { [weak self] ManageCategoryData, isSuccess in
            if isSuccess == true{
                if ManageCategoryData.data?.count == 0{
                    self?.lblNoRecord.isHidden = false
                }else{
                    self?.lblNoRecord.isHidden = true
                    self?.manageCategoryData = ManageCategoryData.data
                    self?.searchCategoryData = ManageCategoryData.data
                    self?.tableViewManageCategory.reloadData()
                }
            }else{
                self?.showSimpleAlert(message: ManageCategoryData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Button action Edit Category APi Call--
    /// Create Function For Edit Category
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapEditBtn(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: UpdateCategoryViewController.identifier) as! UpdateCategoryViewController
        vc.updateCategoryViewModel.id = searchCategoryData?[sender.tag].id ?? 0
        self.navigationController?.pushViewController(vc , animated: true)
    }
    // MARK: Button action Delete Category APi Call--
    /// Create Function For Delete Category
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapDeleteBtn(sender: UIButton){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeleteUser, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
            self.manageCategoryViewModel.callDeleteCategoryApi(id: self.searchCategoryData?[sender.tag].id ?? 0) { [weak self] deleteData, isSuccess in
                if isSuccess == true{
                    self?.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                    self?.manageCategoryApi()
                }else{
                    self?.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                }
                
            }}))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
}
// MARK: Create extension for call tableview delegate and datasource--
extension ManageCategoryViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if searchCategoryData?.count == 0{
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return searchCategoryData?.count ?? 0
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: ManageCategoryTableViewCell.identifier) as! ManageCategoryTableViewCell
        let data = searchCategoryData?[indexPath.row]
        cell.lblName.text = data?.name
        cell.editButton.tag = indexPath.row
        cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
        cell.deleteButton.tag = indexPath.row
        cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
        return cell
    }
}
// MARK: Create a function for search event by name in textfield--
extension ManageCategoryViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                searchCategoryData = manageCategoryData?.filter({ values in
                    return (values.name ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                })
            }else{
                searchCategoryData = manageCategoryData
            }
            tableViewManageCategory.reloadData()
        }
        return true
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
